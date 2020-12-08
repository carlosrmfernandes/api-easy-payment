<?php

namespace App\Service\V1\Transfers;

use Validator;
use App\Repository\V1\User\UserRepository;
use App\Repository\V1\Transfers\TransferRepository;
use App\Components\TransferAuthorization\Client as ClientAuthorization;
use App\Components\Payments\Client as ClientPayment;
use App\Repository\V1\UserWallets\UserWalletRepository;
use App\Jobs\JobUserNotification;

class TransferServiceRegistration
{

    use Traits\RuleTrait;

    protected $transferRepository;

    public function __construct(
        TransferRepository $transferRepository,
        UserRepository $userRepository,
        UserWalletRepository $userWalletRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->transferRepository = $transferRepository;
        $this->userWalletRepository = $userWalletRepository;
    }

    public function store($request)
    {
        $attributes = is_object($request) ? $request->all() : $request;

        $validator = Validator::make($attributes, $this->rules());

        if ($validator->fails()) {
            return $validator->errors();
        }

        $credentials = [
            'email' => auth()->user()->email,
            'password' => $attributes['password'],
        ];

        if (!auth('api')->attempt($credentials)) {
            return 'unidentified user';
        }

        $userPayer = $this->userRepository->show(auth()->user()->id);
        $userPayee = $this->userRepository->show($attributes['user_payee_id']);

        if (!get_object_vars($userPayer) || !get_object_vars($userPayee)) {
            return 'unidentified user';
        }

        if ($attributes['amount'] > $userPayer->wallet->amount) {
            return 'insuficientes balance';
        }

        if (!app(ClientAuthorization::class)->transferAuthorization() ||
                (app(ClientAuthorization::class)->transferAuthorization()->message)!="Autorizado") {
            return 'without authorization for transfers';
        }

        $attributes['user_payer_id'] = auth()->user()->id;

        $this->transferRepository->transfer($attributes);

        return $this->debit($attributes, $userPayer);
    }

    public function debit($attributes, $userPayer)
    {

        $attributesPayee = [
            'amount' => $userPayer->wallet->amount - $attributes['amount'],
            'number_from_wallet' => $userPayer->wallet->number_from_wallet,
            'user_id' => auth()->user()->id
        ];

        $this->userWalletRepository->updateBalance($attributesPayee);

        return $this->credit($attributes);
    }

    public function credit(array $attributes)
    {

        $detailsTransfer = [
            "value" => $attributes['amount'],
            "payer" => $attributes['user_payer_id'],
            "payee" => $attributes['user_payee_id'],
        ];


        $clientPaymentResponse = app(ClientPayment::class)->generatePayment($detailsTransfer);

        if ($clientPaymentResponse && $clientPaymentResponse->message) {

            $userPayee = $this->userRepository->show($attributes['user_payee_id']);

            $attributesPayer = [
                'amount' => $userPayee->wallet->amount + $attributes['amount'],
                'number_from_wallet' => $userPayee->wallet->number_from_wallet,
                'user_id' => $userPayee->wallet->id
            ];

            $this->userWalletRepository->updateBalance($attributesPayer);
            if ($this->userWalletRepository->updateBalance($attributesPayer)) {
                $usersNotification = $this->userRepository->show($attributes['user_payee_id']);
                JobUserNotification::dispatch($usersNotification, $detailsTransfer)->delay(now()->addSecond('15'));
                return 'successful transaction';
            }
        }
        return 'transaction not completed';
    }

}
