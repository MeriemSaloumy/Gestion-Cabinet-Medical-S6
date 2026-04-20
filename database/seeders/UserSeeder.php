<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // Créer un Administrateur
    \App\Models\User::create([
        'name' => 'Admin Test',
        'email' => 'admin@test.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
    ]);

    // Créer un Médecin
    \App\Models\User::create([
        'name' => 'Dr House',
        'email' => 'doctor@test.com',
        'password' => bcrypt('password'),
        'role' => 'medecin',
    ]);
    \App\Models\User::create([
        'name' => 'Sara Secretaire',
        'email' => 'secretaire@test.com',
        'password' => bcrypt('password'),
        'role' => 'secretaire',
    ]);

    \App\Models\User::create([
        'name' => 'Secrétaire Cabinet',
        'email' => 'secretaire@cabinet.com',
        'password' => Hash::make('password123'), // Ton mot de passe
        'role' => 'secretaire',
    ]);

    \App\Models\User::create([
        'name' => 'Ahmed Alami',
        'email' => 'ahmed@patient.com',
        'password' => Hash::make('password123'), // Ton mot de passe
        'role' => 'patient',
    ]);
}
}
