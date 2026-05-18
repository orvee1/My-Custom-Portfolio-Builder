<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && ! auth()->user()->canAccessAdminPanel()) {
            $message = 'Your account is inactive. Please contact the super admin.';

            if (auth()->user()->isPendingApproval()) {
                $message = 'Your account is waiting for super admin approval.';
            }

            if (auth()->user()->isRejected()) {
                $message = auth()->user()->rejection_reason
                    ? 'Your account request was rejected. Reason: ' . auth()->user()->rejection_reason
                    : 'Your account request was rejected. Please contact support.';
            }

            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => $message,
                ]);
        }

        return $next($request);
    }
}
