<?php

namespace App\Service\V1\UserType;

use Illuminate\Http\Request;
use App\Repository\V1\UserType\UserTypeRepository;
use Validator;

class UserTypeServiceUpdate
{

    use Traits\RuleTrait;

    protected $userTypeRepository;

    public function __construct(
        UserTypeRepository $userTypeRepository
    )
    {
        $this->userTypeRepository = $userTypeRepository;
    }

    public function update(int $id, Request $request)
    {
        $attributes = $request->all();

        $validator = Validator::make($request->all(), $this->rules($id));

        if ($validator->fails()) {
            return $validator->errors();
        }

        return $this->userTypeRepository->update($id, $attributes);
    }

}
