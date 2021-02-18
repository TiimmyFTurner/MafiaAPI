<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate(
                [
                    'email' => 'email|required',
                    'name' => 'required',
                    'password' => 'required'
                ]
            );
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return $this->login($request);
        } catch (Exception $error) {
            return response()->json([
                'status' => 500,
                'message' => 'Error in Registration',
                'error' => $error,
            ]);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status_code' => 401,
                    'message' => 'Unauthorized'
                ]);
            }
            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Error in Login');
            }
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status' => 200,
                'data' => ['token' => $tokenResult, 'token_type' => 'Bearer', 'user' => Auth::user()],
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Login',
                'error' => $error,
            ]);
        }
    }
}
