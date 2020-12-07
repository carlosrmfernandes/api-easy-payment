<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MovieFilters
 *
 * @author carlosfernandes
 */

namespace App\Filters\V1\UserType;

use App\Service\V1\UserType\UserTypeServiceAll;

class UserTypeFilters
{

    private $searchQuery;
    private $userTypeServiceAll;

    public function __construct(
        UserTypeServiceAll $userTypeServiceAll
    )
    {
        $this->userTypeServiceAll = $userTypeServiceAll;
    }

    public function apply($request)
    {
        if (!empty($request['searchQuery'])) {
            $this->searchQuery = $request['searchQuery'];
        }
        return $this->userTypeServiceAll->all($this->searchQuery);
    }

}
