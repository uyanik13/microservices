<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Application;
use App\Exceptions\InvalidInputException;
use Illuminate\Support\Facades\Auth;


class UserService
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;

    }

    public function create(array $input)
    {
        if (!$input) {
            throw new InvalidInputException('No input provided');
        }
        
        $input['password'] = Hash::make($input['password']);

        return $this->user->create($input);
    }

    public function authenticate()
    {

        $user = $this->auth->user();
        return $user;
    }


    public function me($token)
    {
        $user = Auth::user();
        return response()->json([
            'status' => 200,
            'message' => 'Authorized.',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 24 * 60 * 60,
            'user' => array(
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->avatar,
                'email' => $user->email,
                'role' => $user->role
            )
        ], 200);




    }


}
