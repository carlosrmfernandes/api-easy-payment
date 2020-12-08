<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Repository\V1\Transfers\TransferRepository;
use App\Service\V1\Transfers\TransferServiceRegistration;
use App\Models\Transfer;
use App\Repository\V1\User\UserRepository;
use App\Repository\V1\UserWallets\UserWalletRepository;
use App\Models\Wallet;
use App\Models\User;

class TransferServiceTest extends TestCase
{

    /**
     * A basic unit test example.
     *
     * @return void
     */
    use \Illuminate\Foundation\Testing\DatabaseTransactions;

    function test_registration_transfer_service()
    {
               
        $attributesCreateUser = [
            "name" => "Texte",
            "email" => "teste@gmail.com",
            "password" => bcrypt(12345),
            "cpf_cnpj" => '81157400043',
            "user_type_id" => 1,
            "is_active" => 1,
        ];

        $user = User::create($attributesCreateUser);
        
         Wallet::create([
                    'amount' => 98.99,
                    'number_from_wallet' => $user->cpf_cnpj,
                    'user_id' => $user->id
        ]);
         
        $this->be($user);
        
        $attributes = [
            "amount" => 1,
            "user_payee_id" => 1,
            "password" => "12345",
        ];

        $transferRepository = new TransferRepository(new Transfer());
        $userRepository = new UserRepository(new User());
        $userWalletRepository = new UserWalletRepository(new Wallet());
        $transferServiceRegistration = new TransferServiceRegistration(
                $transferRepository, $userRepository, $userWalletRepository
        );

        $transferResult = $transferServiceRegistration->store($attributes);
              
        $this->assertEquals($transferResult, "successful transaction");
    }

}
