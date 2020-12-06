<?php

namespace App\Service\V1\User;

use App\Repository\V1\User\UserRepository;

class UserServiceShow
{

    protected $userRepositor;

    public function __construct(UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function show(int $id)
    {                        
        return $this->userRepository->show($id);
    }

}
