<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Service\V1\User\UserServiceRegistration;
use App\Repository\V1\User\UserRepository;
use App\Repository\V1\UserType\UserTypeRepository;
use App\Repository\V1\UserWallets\UserWalletRepository;
use App\Models\User;
use App\Models\UserType;
use App\Models\Wallet;

class UserServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    use \App\Service\V1\User\Traits\RuleTrait;
    use \Illuminate\Foundation\Testing\DatabaseTransactions;
    
    function test_create_user_service()
    {
        $attributes = [
            "name" => "Carlos",
            "email" => "carlos@gmail.com",
            "password" => "12345",
            "cpf_cnpj" => '22895159068',
            "user_type_id" => 1,
            "is_active" => 1,
        ];
        $UserRepository = new UserRepository(new User());
        $userTypeRepository = new UserTypeRepository(new UserType());
        $userWalletRepository = new UserWalletRepository(new Wallet());
        $userRepository = new UserServiceRegistration(
                $UserRepository, $userTypeRepository, $userWalletRepository
        );

        $user = $userRepository->store($attributes);
        
        
        if ($user && !empty($user->user)) {
            $expceted = User::find($user->user->id);
            $this->assertEquals($expceted->id, $user->user->id);            
        } else {
            dd($user);
        }
        
    }
}
