<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required'
        ];

        $validated = $request->validate($rules);

        //$user = DB::table('users')->where('email', $request['email'])->first();

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return [
                'error' => 'invalid credentials',
                'code' => 401
            ];
        }

        $token = str()->random(50);

        $user->token = $token;

        $user->save();

        return [
            'user' => $user,
            'token' => $token,
            'code' => 200
        ];
    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');

        $user = User::where('token', $token)->first();

        $user->token = null;

        $user->update();

        return [
            'code' => 200,
            'logout'
        ];
    }
}
