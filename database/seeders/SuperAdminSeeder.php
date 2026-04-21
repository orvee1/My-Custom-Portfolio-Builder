<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'orvee.imrul32@gmail.com'],
            [
                'name'       => 'Imrul Ibtehaz',
                'password'   => '12345678',
                'role'       => 'super_admin',
                'is_active'  => true,
                'created_by' => null,
            ]
        );
    }
}
