<?php

namespace App\Service\V1\UserType;

use App\Repository\V1\UserType\UserTypeRepository;

class UserTypeServiceAll
{

    protected $userTypeRepository;

    public function __construct(UserTypeRepository $userTypeRepository
    )
    {
        $this->userTypeRepository = $userTypeRepository;
    }

    public function all($searchQuery = null)
    {        
        return $this->userTypeRepository->all($searchQuery);
    }

}
