<?php

namespace App\Service\V1\UserType;

use App\Repository\V1\UserType\UserTypeRepository;


class UserTypeServiceShow
{

    use Traits\RuleTrait;
    protected $userTypeRepository;

    public function __construct(UserTypeRepository $userTypeRepository
    )
    {
        $this->userTypeRepository = $userTypeRepository;
    }

    public function show(int $id)
    {                        
        return $this->userTypeRepository->show($id);
    }

}
