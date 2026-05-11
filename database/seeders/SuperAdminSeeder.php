<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('congresia.super_admin.email', env('SUPER_ADMIN_EMAIL', 'admin@congresia.test'));
        $password = config('congresia.super_admin.password', env('SUPER_ADMIN_PASSWORD', 'password'));
        $name = config('congresia.super_admin.name', env('SUPER_ADMIN_NAME', 'Super Admin'));

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
                'preferred_locale' => 'fr',
            ],
        );

        if (! $user->hasRole('super-admin')) {
            $user->assignRole('super-admin');
        }

        $this->command->info("✓ Super admin créé/mis à jour : {$email}");
        $this->command->warn("  → Mot de passe : {$password}");
        $this->command->warn('  → Change-le immédiatement après ta première connexion !');
    }
}
