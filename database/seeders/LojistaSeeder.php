<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LojistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@email.com'],
            [
                'name' => 'Admin Lojista',
                'password' => \Illuminate\Support\Facades\Hash::make('senha123'),
                'tipo' => 'LOJISTA',
            ]
        );
    }
}
