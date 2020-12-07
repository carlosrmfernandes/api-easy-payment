<?php

namespace App\Service\V1\User;

use Illuminate\Http\Request;
use App\Repository\V1\User\UserRepository;
use App\Repository\V1\UserType\UserTypeRepository;
use function bcrypt;
use Validator;

class UserServiceUpdate
{

    use Traits\RuleTrait;
    use \App\Service\Traits\VerifyCnpjOrCpfTrait;

    protected $userRepository;
    protected $userTypeRepository;

    public function __construct(
        UserRepository $userRepository,
        UserTypeRepository $userTypeRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->userTypeRepository = $userTypeRepository;
    }

    public function update(int $id, Request $request)
    {
        $attributes = $request->all();

        $attributes['cpf_cnpj'] = preg_replace('/[^0-9]/', '', (string) $attributes['cpf_cnpj']);

        if (!$this->cnpjCpf($attributes['cpf_cnpj'])) {
            return "cpf_cnpj invalid";
        }

        $validator = Validator::make($attributes, $this->rules());

        if ($validator->fails()) {
            return $validator->errors();
        }

        if (!get_object_vars(($this->userTypeRepository->show($attributes['user_type_id'])))) {
            return "user_type_id invalid";
        }

        $attributes['password'] = bcrypt($attributes['password']);
        return $this->userRepository->update($id, $attributes);
    }

}
