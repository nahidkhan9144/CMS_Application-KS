<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginCredential(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'pass' => 'required',
        ]);

        $credentials = [
            'name' => $request->username,
            'password' => $request->pass,
        ];

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid Credentials', 'error' => '1'], 401);
        }

        $user = auth()->user();

        return response()->json([
            'message' => 'Login Successfully',
            'error' => '0',
            'token' => $token,
            'user' => $user,
            'user_id' => $user->id
        ], 200);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Logout Successfully', 'error' => '0'], 200);
    }
}
