@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Buku Tamu SMP Mentari</h1>
        <p class="text-gray-600 mt-2">Silakan tinggalkan pesan, kritik, atau saran Anda untuk sekolah kami.</p>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Form Kirim Pesan --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Kirim Pesan Baru</h2>
        <form action="{{ route('bukutamu.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="pesan" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                <textarea id="pesan" name="pesan" rows="4" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('pesan') }}</textarea>
                @error('pesan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md shadow-sm text-sm">
                Kirim Pesan
            </button>
        </form>
    </div>

    {{-- Daftar Pesan Pengunjung --}}
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Daftar Pesan Pengunjung</h2>
        <div class="space-y-4">
            @forelse ($daftar_pesan as $pesan)
                <div class="border-b border-gray-200 pb-4 last:border-b-0">
                    <div class="flex justify-between items-center mb-1">
                        <span class="font-bold text-gray-800">{{ $pesan->nama }}</span>
                        <span class="text-xs text-gray-500">{{ $pesan->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <p class="text-gray-600 text-sm">{{ $pesan->pesan }}</p>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Belum ada pesan yang ditinggalkan.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection