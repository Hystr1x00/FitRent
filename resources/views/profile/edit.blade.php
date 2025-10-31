<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profile') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <div class="pt-10 pb-16 px-4">
            <div class="max-w-5xl mx-auto">
                <!-- Hero Card -->
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 text-white shadow-lg mb-8">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center gap-4">
                            <div class="h-16 w-16 sm:h-20 sm:w-20 rounded-2xl bg-white/10 backdrop-blur flex items-center justify-center text-2xl sm:text-3xl font-extrabold">
                                {{ strtoupper(substr($user->name,0,1)) }}
                            </div>
                            <div>
                                <h1 class="text-2xl sm:text-3xl font-bold leading-tight">{{ $user->name }}</h1>
                                <p class="text-white/90">{{ $user->email }}</p>
                                @if($user->phone)
                                    <p class="text-white/90">{{ $user->phone }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <svg class="absolute -right-10 -bottom-10 w-56 h-56 text-white/10" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M48.3,-69.4C62.7,-62.9,74.5,-52.1,81.3,-38.8C88.1,-25.5,90,-9.7,87.5,5.4C85,20.5,78.1,35,68.4,47.3C58.6,59.7,46,69.8,31.8,75.2C17.7,80.7,2.1,81.6,-12.5,79.1C-27.1,76.7,-40.7,70.9,-52.1,61.7C-63.6,52.6,-72.9,40.1,-79,26.2C-85.2,12.3,-88.2,-3.8,-83.7,-17.5C-79.2,-31.1,-67.2,-42.3,-54.5,-49.3C-41.8,-56.4,-28.5,-59.7,-15.2,-65C-1.9,-70.3,11.5,-77.9,24.8,-78.8C38.1,-79.8,52.3,-74,48.3,-69.4Z" transform="translate(100 100)"/></svg>
                </div>

                @if(session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-green-50 text-green-800 border border-green-200">{{ session('success') }}</div>
                @endif

                <form action="{{ route('profile.update') }}" method="post" class="grid lg:grid-cols-3 gap-6">
                    @csrf
                    @method('PUT')

                    <!-- Left: Account Card -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-2xl shadow p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Akun</h3>
                            <div class="grid sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500" required />
                                    @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500" required />
                                    @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Telepon</label>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500" />
                                    @error('phone')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Preferensi</h3>
                            <label class="block text-sm font-medium text-gray-700">Olahraga Favorit</label>
                            <select name="favorite_sports[]" multiple class="mt-1 w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500">
                                @php
                                    $options = ['futsal','badminton','basket','sepak bola','voli','tenis','renang'];
                                    $selected = old('favorite_sports', $user->favorite_sports ?? []);
                                @endphp
                                @foreach($options as $opt)
                                    <option value="{{ $opt }}" {{ in_array($opt, $selected ?? []) ? 'selected' : '' }}>{{ ucfirst($opt) }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-2">Tahan Ctrl (Windows) / Cmd (Mac) untuk memilih banyak.</p>
                        </div>

                        <div class="bg-white rounded-2xl shadow p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Keamanan</h3>
                            <div class="grid sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Password Baru (opsional)</label>
                                    <input type="password" name="password" class="mt-1 w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500" />
                                    @error('password')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="mt-1 w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Actions / Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow p-6 sticky top-24">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Simpan Perubahan</h3>
                            <p class="text-sm text-gray-600 mb-4">Pastikan data sudah benar sebelum menyimpan.</p>
                            <div class="flex flex-col gap-3">
                                @if(auth()->user()->role === 'user' || auth()->user()->role === null)
                                    <a href="{{ route('dashboard') }}" class="px-5 py-3 rounded-xl border text-center">Batal</a>
                                @elseif(auth()->user()->role === 'field_admin')
                                    <a href="{{ route('admin.dashboard') }}" class="px-5 py-3 rounded-xl border text-center">Batal</a>
                                @elseif(auth()->user()->role === 'superadmin')
                                    <a href="{{ route('superadmin.users.index') }}" class="px-5 py-3 rounded-xl border text-center">Batal</a>
                                @endif
                                <button class="px-5 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


