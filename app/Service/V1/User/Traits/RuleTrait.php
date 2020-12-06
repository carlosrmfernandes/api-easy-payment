<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RuleTrait
 *
 * @author carlosfernandes
 */

namespace App\Service\V1\User\Traits;
trait RuleTrait
{

    public function rules($id = null)
    {
        return [
            'name' => 'required|string|max:255',
            'is_active' => 'required|boolean|max:1',
            'password' => 'required|string|max:255',
            'user_type_id' => 'required|integer|max:255',
            'email' => 'required|string|max:255|unique:users,email' . ($id == null ? '' : ',' . $id),
            'cpf_cnpj' => 'required|string|max:255|unique:users,cpf_cnpj' . ($id == null ? '' : ',' . $id),            
        ];
    }
    
    

}
