@extends('superadmin.layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('superadmin.users.update', $user) }}" method="post" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full px-4 py-2 border rounded-lg" required />
            @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 w-full px-4 py-2 border rounded-lg" required />
            @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Telepon</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 w-full px-4 py-2 border rounded-lg" />
            @error('phone')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Password (opsional)</label>
                <input type="password" name="password" class="mt-1 w-full px-4 py-2 border rounded-lg" />
                @error('password')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="mt-1 w-full px-4 py-2 border rounded-lg" />
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Peran</label>
            <select name="role" class="mt-1 w-full px-4 py-2 border rounded-lg" required>
                <option value="field_admin" {{ old('role', $user->role)==='field_admin' ? 'selected' : '' }}>Admin Lapangan</option>
                <option value="user" {{ old('role', $user->role)==='user' ? 'selected' : '' }}>Pengguna</option>
            </select>
            @error('role')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="flex justify-end gap-2">
            <a href="{{ route('superadmin.users.index') }}" class="px-4 py-2 border rounded-lg">Batal</a>
            <button class="px-4 py-2 bg-primary-600 text-white rounded-lg">Simpan</button>
        </div>
    </form>
</div>
@endsection


