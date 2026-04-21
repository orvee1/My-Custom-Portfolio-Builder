<?php
namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function view(User $user, User $model): bool
    {
        return $user->isSuperAdmin() || $user->id === $model->id;
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, User $model): bool
    {
        return $user->isSuperAdmin() || $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        if (! $user->isSuperAdmin()) {
            return false;
        }

        if ($user->id === $model->id) {
            return false;
        }

        // protect super admin accounts from deletion in this module
        return $model->role !== 'super_admin';
    }

    public function toggleStatus(User $user, User $model): bool
    {
        if (! $user->isSuperAdmin()) {
            return false;
        }

        if ($user->id === $model->id) {
            return false;
        }

        return $model->role !== 'super_admin';
    }
}
