<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Filters\V1\UserType\UserTypeFilters;
use App\Service\V1\UserType\UserTypeServiceShow;
use App\Service\V1\UserType\UserTypeServiceUpdate;
use App\Service\V1\UserType\UserTypeServiceRegistration;

class UserTypeController extends Controller
{

    protected $userTypeFilters;
    protected $userTypeServiceUpdate;
    protected $userTypeServiceShow;
    protected $userTypeServiceRegistration;

    public function __construct(
        UserTypeFilters $userTypeFilters, 
        UserTypeServiceShow $userTypeServiceShow, 
        UserTypeServiceUpdate $userTypeServiceUpdate, 
        UserTypeServiceRegistration $userTypeServiceRegistration
    )
    {
        $this->userTypeFilters = $userTypeFilters;
        $this->userTypeServiceShow = $userTypeServiceShow;
        $this->userTypeServiceUpdate = $userTypeServiceUpdate;
        $this->userServiceRegistration = $userTypeServiceRegistration;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userType = $this->userTypeFilters->apply($request->all());
        return response()->json(['data' => $userType]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): object
    {
        $userType = $this->userServiceRegistration->store($request);

        return response()->json(['data' => $userType]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userType = $this->userTypeServiceShow->show($id);

        return response()->json(['data' => $userType]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, Request $request)
    {

        $userType = $this->userTypeServiceUpdate->update($id, $request);

        return response()->json(['data' => $userType]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

}
