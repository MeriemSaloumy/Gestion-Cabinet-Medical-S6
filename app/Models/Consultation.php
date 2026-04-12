<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consultation extends Model
{
    use HasFactory;
    
    protected $fillable = ['patient_id', 'user_id', 'diagnostic', 'compte_rendu'];

    // Relation inverse : Une consultation appartient à un patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}