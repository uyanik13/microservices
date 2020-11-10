<?php

namespace App\Services;

use App\Models\Authorization;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\InvalidInputException;
use App\Exceptions\InvalidLoginException;
use App\Exceptions\ApiConnectionException;
use App\Transformers\AuthorizationTransformer;



class AuthService
{
    private $userService;


    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function register(array $input)
    {

        if (!$input) {
            throw new InvalidInputException('No input provided');
        }

        $createdUser = $this->userService->create($input);

        return $createdUser;
    }

    public function login($data)
    {
        if (!$data) {
            throw new InvalidInputException('No input provided');
        }

        try {
            if (! $token = Auth::attempt($data)) {
                $this->response->errorUnauthorized(trans('auth.incorrect'));
            }

            $data = $this->userService->me($token);
            return $data;

        } catch (InvalidLoginException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new ApiConnectionException('Cannot connect to OAuth API'. $e->getMessage());
        }
    }







}
