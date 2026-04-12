<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConsultationTest extends TestCase
{
    use RefreshDatabase; // Cela nettoie la base de données après le test

    public function test_medecin_can_create_consultation()
    {
        $this->withoutExceptionHandling();
        // 1. Créer un médecin manuellement (pour éviter l'erreur Factory)
        $medecin = User::create([
            'name' => 'Dr Test',
            'email' => 'dr@test.com',
            'password' => bcrypt('password'),
            'role' => 'medecin',
        ]);

        // 2. Créer un patient manuellement
        $patient = Patient::create([
            'nom' => 'Doe',
            'prenom' => 'John',
            'cin' => 'AB12345',
            'telephone' => '0600000000',
            'date_naissance' => '1990-01-01',
        ]);

        // 3. Simuler la connexion et l'envoi du formulaire de consultation
        $response = $this->actingAs($medecin)->post(route('consultations.store'), [
            'patient_id' => (string)$patient->id,
            'diagnostic' => 'Rhume',
            'compte_rendu' => 'Repos et paracétamol',
        ]);

        // 4. Vérifier que la consultation existe en base de données
        $this->assertDatabaseHas('consultations', [
            'diagnostic' => 'Rhume'
        ]);

        // 5. Vérifier que le système redirige bien (preuve que l'enregistrement a réussi)
        $response->assertStatus(302); 
    }
}