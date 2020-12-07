<?php

namespace App\Repository\V1\UserWallets;

use App\Models\Wallet;
use App\Repository\V1\BaseRepository;
use Illuminate\Support\Facades\DB;

class UserWalletRepository extends BaseRepository
{

    public function __construct(Wallet $Wallet)
    {
        parent::__construct($Wallet);
    }

    public function save(array $attributes): object
    {
        DB::beginTransaction();
        try {
            $userWallet = $this->obj->create($attributes);
            DB::commit();
            return $userWallet;
        } catch (Exception $ex) {
            DB::rollback();
            return $ex->getMessage();
        }
    }
    
    public function updateBalance(array $attributes): object
    {        
        DB::beginTransaction();
        try {            
            $userWallet = $this->obj->find($attributes['user_id']);
            if ($userWallet) {
                $userWallet->updateOrCreate([
                    'id' => $attributes['user_id'],
                        ], $attributes);
            }
            DB::commit();
            return (object) $userWallet;
        } catch (Exception $ex) {
            DB::rollback();
            return $ex->getMessage();
        }
    }

}
