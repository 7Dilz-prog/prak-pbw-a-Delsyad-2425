<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="simple-card">
                <div class="simple-card-header">
                    <h3 class="simple-card-title">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="simple-card-subtitle">Anda berhasil masuk ke sistem LaraPress.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
