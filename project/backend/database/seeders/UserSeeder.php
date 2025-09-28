<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Администратор',
            'email' => 'admin@shop.ru',
            'password' => Hash::make('QWEasd123'),
        ]);

        User::create([
            'name' => 'Тестовый Клиент',
            'email' => 'user@shop.ru',
            'password' => Hash::make('password'),
        ]);

    }
}
