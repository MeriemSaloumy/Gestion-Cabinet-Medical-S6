<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de Bord Médecin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Bienvenue Docteur ") }} {{ Auth::user()->name }} !
                    <p class="mt-4 text-sm text-gray-600">
                        Ici, vous pourrez bientôt gérer vos rendez-vous et vos patients.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>