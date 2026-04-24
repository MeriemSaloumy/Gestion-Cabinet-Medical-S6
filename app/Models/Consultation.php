<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consultation extends Model
{
    use HasFactory;
    
    
    protected $fillable = [
    'patient_id', 
    'user_id', 
    'diagnostic', 
    'compte_rendu', 
    'ordonnance', // <--- TRÈS IMPORTANT : AJOUTE ÇA
    'tension',    // Ajoute aussi ça
    'poids'       // Et ça
];
    // Relation inverse : Une consultation appartient à un patient
    
    public function patient()
{
    // On lie la consultation à l'utilisateur (le patient) dans la table 'users'
    return $this->belongsTo(User::class, 'patient_id');
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}