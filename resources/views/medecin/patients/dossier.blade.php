@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body">
            <h4 class="fw-bold text-primary">Dossier Médical : {{ $patient->nom }} {{ $patient->prenom }}</h4>
            <p><strong>CIN :</strong> {{ $patient->cin }} | <strong>Âge :</strong> {{ $patient->date_naissance }}</p>
        </div>
    </div>

    <h5 class="mb-3">Historique des visites</h5>
    @foreach($historique as $item)
    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h6>Visite du {{ $item->created_at->format('d/m/Y') }}</h6>
                <a href="{{ route('medecin.ordonnance.pdf', $item->id) }}" class="btn btn-sm btn-outline-danger">Imprimer Ordonnance</a>
            </div>
            <p><strong>Diagnostic :</strong> {{ $item->diagnostic }}</p>
            <p><strong>Compte-rendu :</strong> {{ $item->compte_rendu }}</p>
            <div class="bg-light p-2 rounded">
                <strong>Ordonnance :</strong><br>
                {!! nl2br(e($item->ordonnance)) !!}
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection