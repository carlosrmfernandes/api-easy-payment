<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Service\V1\User\UserServiceRegistration;
use App\Service\V1\User\UserServiceShow;
use App\Http\Controllers\Controller;
use App\Service\V1\User\UserServiceUpdate;


class UserController extends Controller
{

    protected $userServiceRegistration;
    protected $userServiceUpdate;
    protected $userServiceShow;


    public function __construct(
        UserServiceRegistration $userServiceRegistration, 
        UserServiceUpdate $userServiceUpdate,
        UserServiceShow $userServiceShow

    )
    {
        $this->userServiceShow = $userServiceShow;
        $this->userServiceUpdate = $userServiceUpdate;
        $this->userServiceRegistration = $userServiceRegistration;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $this->userServiceRegistration->store($request);

        return response()->json(['data' => $user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userServiceShow->show($id);

        return response()->json(['data' => $user]);
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
        
        $user = $this->userServiceUpdate->update($id,$request);

        return response()->json(['data' => $user]);
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
