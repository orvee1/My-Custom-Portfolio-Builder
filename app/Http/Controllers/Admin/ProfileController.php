<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UpdatePasswordRequest;
use App\Http\Requests\Admin\User\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();

        $data = [
            'name'  => trim($request->name),
            'email' => strtolower(trim($request->email)),
        ];

        if ($user->email !== $data['email']) {
            $data['email_verified_at'] = null;
        }

        DB::transaction(function () use ($user, $data) {
            $user->update($data);
        });

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $user = $request->user();

        DB::transaction(function () use ($user, $request) {
            $user->update([
                'password' => $request->password,
            ]);
        });

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'Password updated successfully.');
    }
}
