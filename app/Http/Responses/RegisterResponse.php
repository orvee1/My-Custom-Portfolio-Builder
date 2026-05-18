<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        Auth::guard(config('fortify.guard', 'web'))->logout();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('status', 'Registration submitted successfully. Your account is waiting for super admin approval.');
    }
}
