<?php
namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Http\Responses\RegisterResponse;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(RegisterResponseContract::class, RegisterResponse::class);
    }

    public function boot(): void
    {
        $this->configureActions();
        $this->configureViews();
        $this->configureAuthentication();
        $this->configureRateLimiting();
    }

    private function configureActions(): void
    {
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::createUsersUsing(CreateNewUser::class);
    }

    private function configureViews(): void
    {
        Fortify::loginView(fn() => view('livewire.auth.login'));
        Fortify::verifyEmailView(fn() => view('livewire.auth.verify-email'));
        Fortify::twoFactorChallengeView(fn() => view('livewire.auth.two-factor-challenge'));
        Fortify::confirmPasswordView(fn() => view('livewire.auth.confirm-password'));
        Fortify::registerView(fn() => view('livewire.auth.register'));
        Fortify::resetPasswordView(fn() => view('livewire.auth.reset-password'));
        Fortify::requestPasswordResetLinkView(fn() => view('livewire.auth.forgot-password'));
    }

    private function configureAuthentication(): void
    {
        Fortify::authenticateUsing(function (Request $request) {
            $email = strtolower(trim((string) $request->input('email')));

            $user = User::query()
                ->where('email', $email)
                ->first();

            if (! $user || ! Hash::check((string) $request->input('password'), $user->password)) {
                return null;
            }

            if ($user->isPendingApproval()) {
                throw ValidationException::withMessages([
                    'email' => 'Your account is waiting for super admin approval.',
                ]);
            }

            if ($user->isRejected()) {
                throw ValidationException::withMessages([
                    'email' => $user->rejection_reason
                        ? 'Your account request was rejected. Reason: ' . $user->rejection_reason
                        : 'Your account request was rejected. Please contact support.',
                ]);
            }

            if (! $user->is_active) {
                throw ValidationException::withMessages([
                    'email' => 'Your account is inactive. Please contact the super admin.',
                ]);
            }

            return $user;
        });
    }

    private function configureRateLimiting(): void
    {
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });
    }
}
