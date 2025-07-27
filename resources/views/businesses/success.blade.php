@extends('layouts.app')

@section('title', 'Uspešna Prijava - Platforma za Invalide')

@section('content')
<div class="bg-green-50 min-h-screen flex items-center justify-center py-12">
    <div class="max-w-md mx-auto text-center">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="mb-6">
                <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-check text-green-600 text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Uspešno poslano!</h1>
                <p class="text-gray-600">Vaša prijava je uspešno poslata i čeka odobrenje administratora.</p>
            </div>
            
            <div class="bg-blue-50 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-800">
                    <i class="fas fa-clock mr-2"></i>
                    Očekujte odobrenje u roku od 24-48 sati. Kontaktiraćemo vas na navedeni broj telefona.
                </p>
            </div>
            
            <div class="space-y-3">
                <a href="{{ route('business.index') }}" class="block w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                    Pogledaj Biznise
                </a>
                <a href="{{ route('home') }}" class="block w-full border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50 transition-colors">
                    Nazad na Početnu
                </a>
            </div>
        </div>
    </div>
</div>
@endsection