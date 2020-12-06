<?php

namespace App\Repository\V1\UserType;

use App\Models\UserType;
use App\Repository\V1\BaseRepository;
use Illuminate\Support\Facades\DB;

class UserTypeRepository extends BaseRepository
{

    public function __construct(UserType $userType)
    {
        parent::__construct($userType);
    }

    public function save(array $attributes): object
    {
        DB::beginTransaction();
        try {
            $userType = $this->obj->create($attributes);
            DB::commit();
            return $userType;
        } catch (Exception $ex) {
            DB::rollback();
            return $ex->getMessage();
        }
    }

    public function update(int $id, array $attributes): object
    {
        DB::beginTransaction();
        try {
            $userType = $this->obj->find($id);
            if ($userType) {
                $userType->updateOrCreate([
                    'id' => $id,
                        ], $attributes);
            }
            DB::commit();
            return (object) $userType;
        } catch (Exception $ex) {
            DB::rollback();
            return $ex->getMessage();
        }
    }

    public function show(int $id): object
    {

        return (object) $this->obj->where('id', $id)->first();
    }

    public function all($searchQuery = null): object
    {
        if ($searchQuery) {
            return $this->obj
                            ->where('name', 'ilike', '%' . $searchQuery . '%')
                            ->get();
        }
        return $this->obj->all();
    }

}
