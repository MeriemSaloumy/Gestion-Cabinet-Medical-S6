<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'medecin_id', 'appointment_date', 'status', 'motif', 'notes'
    ];
   
    protected $casts = [
        'appointment_date' => 'datetime',
    ];
    // Dans Appointment.php
    public function prescription() {
        return $this->hasOne(Prescription::class);
    }

   
    public function patient()
{
    // On lie le rendez-vous à la table 'users' via la colonne 'patient_id'
    return $this->belongsTo(User::class, 'patient_id');
}

    public function medecin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'medecin_id');
    }
}