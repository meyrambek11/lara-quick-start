<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $this->validateLogin($request);

        try{
            return $this->attemptLogin($request->email, $request->password);
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    protected function validateLogin(Request $request): void
    {
        $request->validate([
            "email" => "required | string",
            "password" => "required | string"
        ]);
    }

    protected function attemptLogin(string $email, string $password): string{
        $user = User::where("email","=", $email)->first();

        if(! $user) throw new \Exception('User Not Found');

        if(!$this->isValidPassword($password, $user->password)) throw new \Exception('User Not Found');

        $token = JWTAuth::attempt(['email'=> $email,'password'=> $password]);

        return $token;
    }

    protected function isValidPassword(string $rqPassword, string $userPassword): bool {
        return Hash::check($rqPassword, $userPassword);
    }
}
