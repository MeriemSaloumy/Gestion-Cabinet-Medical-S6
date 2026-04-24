<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('consultations')) {
            Schema::create('consultations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('patient_id');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->text('diagnostic')->nullable();
                $table->text('compte_rendu')->nullable();
                $table->text('ordonnance')->nullable();
                $table->string('tension')->nullable();
                $table->decimal('poids', 5, 2)->nullable();
                $table->timestamps();
                
               
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
                // Remplace la ligne actuelle par celle-ci :
                $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};