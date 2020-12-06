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

namespace App\Service\Traits;

trait VerifyCnpjOrCpfTrait
{

    public function cnpjCpf($cnpjCpf)
    {
        if (strlen($cnpjCpf) == 14) {
            return $this->verify_cnpj($cnpjCpf);
        }
        if (strlen($cnpjCpf) == 11) {
            return $this->verify_cpf($cnpjCpf);
        }
    }

    public function verify_cnpj($cnpj)
    {

        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
            return false;

        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }

    function verify_cpf($cnpjCpf)
    {
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cnpjCpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cnpjCpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

}
