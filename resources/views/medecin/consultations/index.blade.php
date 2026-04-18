
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-blue-600 text-white px-6 py-4 font-bold text-lg flex justify-between items-center">
            <span>Historique de toutes les Consultations</span>
        </div>

        <div class="p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <table class="min-w-full bg-white border">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
                        <th class="py-3 px-6 text-left">Date</th>
                        <th class="py-3 px-6 text-left">Patient</th>
                        <th class="py-3 px-6 text-left">Diagnostic</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @forelse($consultations as $consultation)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-6 text-left">{{ $consultation->created_at->format('d/m/Y') }}</td>
                        <td class="py-3 px-6 text-left font-bold">
                            {{ $consultation->patient->nom }} {{ $consultation->patient->prenom }}
                        </td>
                        <td class="py-3 px-6 text-left">{{ Str::limit($consultation->diagnostic, 50) }}</td>
                        <td class="py-3 px-6 text-center">
                            <a href="{{ route('medecin.consultations.pdf', $consultation->id) }}" 
                               class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-xs font-bold transition">
                                📄 PDF
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-gray-500">Aucune consultation trouvée.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection