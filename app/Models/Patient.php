<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{   
    use HasFactory;
    // Autorise le remplissage de ces colonnes
    protected $fillable = ['nom', 'prenom', 'cin', 'telephone', 'date_naissance', 'adresse'];

    // Relation : Un patient a plusieurs consultations
    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
        // Vérifie bien que la colonne dans ta table 'patients' s'appelle 'user_id'
    }
    
}
