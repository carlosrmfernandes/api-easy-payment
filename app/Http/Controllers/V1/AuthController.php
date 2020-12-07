<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\V1;

/**
 * Description of AuthController
 *
 * @author carlosfernandes
 */
use function auth;
use function request;
use function response;
use App\Http\Controllers\Controller;
use App\Service\V1\User\UserServiceLogin;

class AuthController extends Controller
{

    protected $userServiceLogin;

    public function __construct(
        UserServiceLogin $userServiceLogin
    )
    {
        $this->middleware('apiJwt', ['except' => ['login']]);
        $this->userServiceLogin = $userServiceLogin;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {

        $credentials = request(['email', 'password']);

        if ($this->userServiceLogin->login($credentials)) {
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Usuário Não autorizado'], 401);
            }
            return $this->respondWithToken($token);
        } else {
            return response()->json(['data' => 'Usuário Não foi encontrado']);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['data' => 'Sucesso']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = auth('api')->user();
        return response()->json([
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth('api')->factory()->getTTL() * 60,
                    'user' => $user
        ]);
    }

}
