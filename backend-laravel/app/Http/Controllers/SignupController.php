<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;

class SignupController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:10'
        ];

        $validated = $request->validate($rules);

        $token = str()->random(50);

        $validated['token'] = $token;
        
        $user = User::create($validated);

        return [
            'message' => 'already created with successfull',
            'user' => new UserResource($user),
            'token' => $token,
            'device' => Agent::platform()
        ];
    }
}
