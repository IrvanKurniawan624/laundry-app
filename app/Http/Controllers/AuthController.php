<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiFormatter;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $rules = [
            'email'    => 'required|email',
            'password' => 'required',
        ];

        $messages = [
            'email.required'    => 'Email wajib diisi',
            'email.email'       => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return ApiFormatter::validate(json_encode($validator->errors()));
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, true)) {
            $user = Auth::user();

            if (!in_array($user->level, ['admin', 'pegawai'])) {
                Auth::logout();
                return ApiFormatter::error(403, 'Anda tidak berhak login');
            }

            return ApiFormatter::success(
                201,
                'Anda berhasil login',
                route('dashboard')
            );
        }

        return ApiFormatter::error(401, 'Email atau password salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
