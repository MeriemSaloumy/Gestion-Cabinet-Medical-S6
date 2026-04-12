<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('patients', function (Blueprint $table) {
        $table->id();
        $table->string('nom'); // [cite: 17]
        $table->string('prenom');
        $table->string('cin')->unique(); // Pour éviter les doublons
        $table->string('telephone');
        $table->date('date_naissance');
        $table->text('adresse')->nullable();
        $table->timestamps(); // Crée created_at et updated_at automatiquement
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
