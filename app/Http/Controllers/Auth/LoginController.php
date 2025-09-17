<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override the login attempt to block suspended vendors
     */
    protected function attemptLogin(Request $request)
    {
        $user = \App\Models\User::where('email', $request->input('email'))->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($request->input('password'), $user->password)) {
            // If user is a vendor and suspended → block login
            if ($user->vendor && $user->vendor->status === 'suspended') {
                return false;
            }

            // Otherwise continue login
            return $this->guard()->attempt(
                $this->credentials($request),
                $request->filled('remember')
            );
        }

        return false;
    }


    /**
     * Custom error message for failed login
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $user = \App\Models\User::where('email', $request->input('email'))->first();

        if ($user && $user->vendor && $user->vendor->status === 'suspended') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                $this->username() => ['Your account is suspended. Please contact the admin (kingotsima@gmail.com) to restore your privileges.'],
            ]);
        }

        throw \Illuminate\Validation\ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

}

