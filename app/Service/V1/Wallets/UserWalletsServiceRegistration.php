<?php

namespace App\Service\V1\UserType;

use Illuminate\Http\Request;
use App\Repository\V1\UserType\UserWalletsRepository;


class UserWalletsServiceRegistration
{



    protected $userWalletsRepository;

    public function __construct(UserWalletsRepository $userWalletsRepository
    )
    {
        $this->userWalletsRepository = $userWalletsRepository;
    }

    public function store(Request $request)
    {        
        $attributes = $request->all();
        
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return $validator->errors();
        }

        return $this->userWalletsRepository->save($attributes);
    }

}
