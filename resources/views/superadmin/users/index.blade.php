@extends('superadmin.layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center space-x-2">
        <a href="{{ route('superadmin.users.index', ['role' => 'field_admin']) }}" class="px-4 py-2 rounded-lg {{ request('role') === 'field_admin' ? 'bg-primary-600 text-white' : 'bg-white text-gray-700 border' }}">Admin Lapangan</a>
        <a href="{{ route('superadmin.users.index', ['role' => 'user']) }}" class="px-4 py-2 rounded-lg {{ request('role') === 'user' ? 'bg-primary-600 text-white' : 'bg-white text-gray-700 border' }}">Pengguna</a>
    </div>
    <a href="{{ route('superadmin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700"><i class="fas fa-plus mr-2"></i>Tambah Pengguna</a>
</div>

<form method="get" class="mb-4">
    <div class="flex gap-2">
        <input type="hidden" name="role" value="{{ request('role') }}" />
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama/email/telepon" class="w-full px-4 py-2 border rounded-lg" />
        <button class="px-4 py-2 bg-gray-800 text-white rounded-lg">Cari</button>
    </div>
    @if(session('success'))
        <div class="mt-3 p-3 bg-green-50 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="mt-3 p-3 bg-red-50 text-red-800 rounded">Terjadi kesalahan input.</div>
    @endif
    @if(isset($search) && $search)
        <p class="text-sm text-gray-500 mt-2">Hasil untuk: <span class="font-medium">{{ $search }}</span></p>
    @endif
    @if(isset($role) && $role)
        <p class="text-sm text-gray-500">Filter peran: <span class="font-medium">{{ $role === 'field_admin' ? 'Admin Lapangan' : 'Pengguna' }}</span></p>
    @endif
    <p class="text-sm text-gray-500">Total: <span class="font-medium">{{ $users->total() }}</span></p>
</form>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-4 py-3 text-sm font-semibold text-gray-600">Nama</th>
                <th class="text-left px-4 py-3 text-sm font-semibold text-gray-600">Email</th>
                <th class="text-left px-4 py-3 text-sm font-semibold text-gray-600">Telepon</th>
                <th class="text-left px-4 py-3 text-sm font-semibold text-gray-600">Peran</th>
                <th class="text-right px-4 py-3 text-sm font-semibold text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($users as $user)
                <tr>
                    <td class="px-4 py-3">{{ $user->name }}</td>
                    <td class="px-4 py-3">{{ $user->email }}</td>
                    <td class="px-4 py-3">{{ $user->phone }}</td>
                    <td class="px-4 py-3">{{ $user->role === 'field_admin' ? 'Admin Lapangan' : 'Pengguna' }}</td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="{{ route('superadmin.users.edit', $user) }}" class="inline-flex items-center px-3 py-2 border rounded-lg text-gray-700 hover:bg-gray-50"><i class="fas fa-edit mr-2"></i>Edit</a>
                        <form action="{{ route('superadmin.users.destroy', $user) }}" method="post" class="inline" onsubmit="return confirm('Hapus pengguna ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="inline-flex items-center px-3 py-2 border rounded-lg text-red-600 hover:bg-red-50"><i class="fas fa-trash mr-2"></i>Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $users->links() }}</div>
@endsection


