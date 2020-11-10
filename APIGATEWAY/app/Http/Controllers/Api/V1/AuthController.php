<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Authorization;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Transformers\AuthorizationTransformer;

class AuthController extends BaseController
{
    
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $credentials = $request->only('email', 'password');
        return $this->authService->login($credentials);
    }



    public function register(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        return  $this->authService->register($request->all());
    }



        public function logout()
        {
            Auth::logout();
            return response()->json(['message'=> 'Logout Succesfull'], 201);
        }


        public function update()
        {
            $authorization = new Authorization(Auth::refresh());
            return $this->response->item($authorization, new AuthorizationTransformer());
        }

   
}
