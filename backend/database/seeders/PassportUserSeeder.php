<?php

namespace Database\Seeders;

use app\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PassportUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('passwd'),
        ]);

        echo "Utworzono użytkownika:\n";
        echo "ID: {$user->id}\n";
        echo "Email: {$user->email}\n";
        echo "Hasło: passwd\n"; // tylko w dev, nie zapisuj plaintext
    }
}
