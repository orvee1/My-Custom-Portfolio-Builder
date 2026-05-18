<?php
namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
             ...$this->profileRules(),
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'name'             => trim($input['name']),
            'email'            => strtolower(trim($input['email'])),
            'password'         => $input['password'],

            // Public registrations become admin users,
            // but they cannot log in until super admin approves them.
            'role'             => 'admin',
            'created_by'       => null,
            'is_active'        => false,
            'approval_status'  => 'pending',
            'approved_at'      => null,
            'approved_by'      => null,
            'rejected_at'      => null,
            'rejection_reason' => null,
        ]);
    }
}
