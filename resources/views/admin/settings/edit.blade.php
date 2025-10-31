@extends('admin.layouts.app')

@section('title', 'Pengaturan')
@section('subtitle', 'Kelola profil admin lapangan')

@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow p-6">
            @if(session('success'))
                <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-800">{{ session('success') }}</div>
            @endif

            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Akun</h3>
            <form action="{{ route('admin.settings.update') }}" method="post" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-primary-500" required />
                        @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-primary-500" required />
                        @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-primary-500" />
                        @error('phone')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password Baru (opsional)</label>
                        <input type="password" name="password" class="mt-1 w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-primary-500" />
                        @error('password')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="mt-1 w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-primary-500" />
                    </div>
                </div>

                <div class="flex justify-end gap-2">
                    <button class="px-5 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div>
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                    @if($user->phone)
                        <p class="text-sm text-gray-600">{{ $user->phone }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


