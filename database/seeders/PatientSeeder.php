<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      Patient::create([
            'nom' => 'Alami',
            'prenom' => 'Ahmed',
            'cin' => 'AB123456',
            'telephone' => '0661223344',
            'date_naissance' => '1985-05-15',
            'adresse' => 'Sidi Abbad, Marrakech',
        ]);

      // Patient 2
      Patient::create([
          'nom' => 'Berrada',
          'prenom' => 'Laila',
          'cin' => 'K789012',
          'telephone' => '0670556677',
          'date_naissance' => '1992-11-02',
          'adresse' => 'Gueliz, Marrakech',
      ]);

      // Patient 3 (Test pour les mineurs)
      Patient::create([
          'nom' => 'Tazi',
          'prenom' => 'Yassine',
          'cin' => 'M112233',
          'telephone' => '0655443322',
          'date_naissance' => '2015-08-20',
          'adresse' => 'Daoudiate, Marrakech',
      ]);
        //
    }
}
