<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $editorRole = Role::create(['name' => 'Editor']);
        $adminRole = Role::create(['name' => 'Admin']);

        $user = User::create([
            'name' => 'KasparsM',
            'email' => 'kminajevs@example.com',
            'password' => Hash::make('kaspiks12')
        ]);

        $user->assignRole($adminRole);

        $users = User::factory()
            ->count(10)
            ->create();

        $users->each(function ($user) use ($editorRole) {
            $user->assignRole($editorRole);
        });

        $user2 = User::create([
            'name' => 'KasparsM2',
            'email' => 'k2@example.com',
            'password' => Hash::make('kaspiks12')
        ]);

        $user2->assignRole($editorRole);
    }
}
