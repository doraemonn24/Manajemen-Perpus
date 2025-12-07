@php
    // Logika Otomatis Memilih Layout Berdasarkan Role User
    $layout = 'layouts.app'; // Default fallback
    if(Auth::user()->role == 'mahasiswa') {
        $layout = 'mahasiswa.app';
    } elseif(Auth::user()->role == 'pegawai') {
        $layout = 'pegawai.app';
    } elseif(Auth::user()->role == 'admin') {
        $layout = 'admin.app'; // Sesuaikan jika layout admin namanya berbeda
    }
@endphp

@extends($layout)

@section('title', 'Pengaturan Akun')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-4">
            Pengaturan Akun
        </h2>

        {{-- Form 1: Update Informasi Profil (Nama & Email) --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border border-gray-100">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Form 2: Update Password --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border border-gray-100">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Form 3: Hapus Akun --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border border-gray-100">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection