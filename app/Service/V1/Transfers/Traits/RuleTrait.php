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

namespace App\Service\V1\Transfers\Traits;

trait RuleTrait
{

    public function rules()
    {
        return [
            'amount' => 'required|numeric',            
            'user_payee_id' => 'required|integer',
            'password' => 'required',
        ];
    }

}
