@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Toutes les consultations</h1>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Diagnostic</th>
                <th>Date</th>
                <th>Ordonnance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultations as $consultation)
            <tr>
                <td>{{ $consultation->patient->nom ?? 'N/A' }} {{ $consultation->patient->prenom ?? '' }}</td>
                <td>{{ $consultation->diagnostic }}</td>
                <td>{{ $consultation->created_at->format('d/m/Y') }}</td>
                <td>
                    @if($consultation->ordonnance)
                        <a href="{{ route('ordonnance.pdf', $consultation->id) }}" class="btn btn-sm btn-primary">Voir PDF</a>
                    @else
                        Aucune
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    {{ $consultations->links() }}
</div>
@endsection