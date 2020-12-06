<?php

namespace App\Service\V1\User;

use App\Repository\V1\User\UserRepository;

class UserServiceLogin
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function login(array $credentials)
    {
                        
        return $this->userRepository->login("email",$credentials['email']);
    }
    

}
