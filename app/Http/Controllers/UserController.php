<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function showAll(Request $request)
    {
        return User::all();
    }

    public function show(string $id){
        $user = User::findOrFail($id);
        // Log::info($user);
        return $user;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required | string',
            'surname' => 'required | string',
            'middle_name'=> 'string',
            'email' => 'required | string',
            'password' => 'required | string',
        ]);

        $newUser = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => $request->password,
            'middle_name' => $request->middle_name
        ]);

        return $newUser;
    }
}
