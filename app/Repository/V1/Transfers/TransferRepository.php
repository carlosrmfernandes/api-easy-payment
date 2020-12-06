<?php

namespace App\Repository\V1\Transfers;

use App\Models\Transfer;
use App\Repository\V1\BaseRepository;
use Illuminate\Support\Facades\DB;

class TransferRepository extends BaseRepository
{

    public function __construct(Transfer $Wallet)
    {
        parent::__construct($Wallet);
    }

    public function transfer(array $attributes): object
    {
        DB::beginTransaction();
        try {
            $transfer = $this->obj->create($attributes);
            DB::commit();
            return $transfer;
        } catch (Exception $ex) {
            DB::rollback();
            return $ex->getMessage();
        }
    }

}
