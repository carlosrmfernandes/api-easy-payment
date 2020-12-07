<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Wallet;


class UserTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    use \App\Service\V1\User\Traits\RuleTrait;
    use \Illuminate\Foundation\Testing\DatabaseTransactions;

    public function test_if_user_columns_is_correct()
    {
        $user = new User();

        $expected = [
            'name',
            'email',
            'password',
            'cpf_cnpj',
            'user_type_id',
            'is_active'
        ];

        $arrayCompared = array_diff($expected, $user->getFillable());

        $this->assertEquals(0, count($arrayCompared));
    }

    public function test_create_user()
    {
        $attributes = [
            "name" => "Carlos",
            "email" => "carlos@gmail.com",
            "password" => bcrypt(12345),
            "cpf_cnpj" => '22895159068',
            "user_type_id" => 1,
            "is_active" => 1,
        ];
        User::create($attributes);

        $this->assertDatabaseHas('users', [
            'name' => 'Carlos',
            'email' => 'carlos@gmail.com',
            'cpf_cnpj' => '22895159068',
            'user_type_id' => 1,
            'is_active' => 1
        ]);

        $this->assertTrue(true);
    }

    public function test_create_user_wallet()
    {
        $attributes = [
            "name" => "Carlos",
            "email" => "carlos@gmail.com",
            "password" => bcrypt(12345),
            "cpf_cnpj" => '22895159068',
            "user_type_id" => 1,
            "is_active" => 1,
        ];
        $user = User::create($attributes);

        Wallet::create([
            'amount' => 98.99,
            'number_from_wallet' => $user->cpf_cnpj,
            'user_id' => $user->id
        ]);


        $this->assertDatabaseHas('wallets', [
            'user_id' => $user->id
        ]);
    }

    public function test_get_user_by_wallet()
    {
        $attributes = [
            "name" => "Carlos",
            "email" => "carlos@gmail.com",
            "password" => bcrypt(12345),
            "cpf_cnpj" => '22895159068',
            "user_type_id" => 1,
            "is_active" => 1,
        ];
        $user = User::create($attributes);

        $wallet = Wallet::create([
                    'amount' => 98.99,
                    'number_from_wallet' => $user->cpf_cnpj,
                    'user_id' => $user->id
        ]);
        $wallet = Wallet::find($wallet->id);
        $result = $user->wallet;
        $this->assertEquals($wallet, $result);
    }

}
