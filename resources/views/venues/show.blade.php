<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $venue->name }}
            </h2>
            <a href="{{ route('venues.index') }}" class="text-indigo-600 hover:text-indigo-800">
                ← Back to Venues
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <div class="pt-24 pb-16 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Venue Details -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="relative">
                                <img src="{{ $venue->image }}" alt="{{ $venue->name }}" class="w-full h-64 object-cover">
                                <div class="absolute top-4 right-4 bg-white px-3 py-1 rounded-full text-lg font-semibold text-blue-600">
                                    Rp {{ number_format($venue->price, 0, ',', '.') }}
                                </div>
                                <div class="absolute top-4 left-4 bg-blue-600 text-white px-3 py-1 rounded-full text-lg font-semibold">
                                    {{ $venue->sport }}
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $venue->name }}</h3>
                                
                                <!-- Location -->
                                <div class="flex items-center mb-4">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-gray-600">{{ $venue->location }}</span>
                                </div>
                                
                                <!-- Rating -->
                                <div class="flex items-center mb-4">
                                    <div class="flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $venue->rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="ml-3 text-lg text-gray-600">{{ $venue->rating }}</span>
                                </div>
                                
                                <!-- Description -->
                                <div class="mb-6">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Description</h4>
                                    <p class="text-gray-700">{{ $venue->description }}</p>
                                </div>
                                
                                <!-- Facilities -->
                                <div class="mb-6">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-3">Facilities</h4>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                        @foreach(json_decode($venue->facilities) as $facility)
                                            <div class="flex items-center bg-gray-50 px-3 py-2 rounded-md">
                                                <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <span class="text-sm text-gray-700">{{ $facility }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Booking Section -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow-md sticky top-6">
                            <div class="p-6">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Book This Venue</h4>
                                
                                @auth
                                    <a href="{{ route('venues.booking', $venue) }}" class="w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white px-4 py-3 rounded-lg hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-center block font-medium mb-4">
                                        Book Now
                                    </a>
                                @else
                                    <div class="text-center mb-4">
                                        <p class="text-gray-600 mb-4">Please login to book this venue</p>
                                        <a href="{{ route('login') }}" class="w-full bg-gray-600 text-white px-4 py-3 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-center block font-medium">
                                            Login
                                        </a>
                                    </div>
                                @endauth
                                
                                <div class="border-t pt-6">
                                    <h5 class="font-semibold text-gray-900 mb-2">Price Details</h5>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Base Price</span>
                                            <span class="font-medium">Rp {{ number_format($venue->price, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Duration</span>
                                            <span class="font-medium">1 Hour</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Service Fee</span>
                                            <span class="font-medium">Rp 10,000</span>
                                        </div>
                                        <div class="border-t pt-2">
                                            <div class="flex justify-between font-semibold">
                                                <span>Total</span>
                                                <span>Rp {{ number_format($venue->price + 10000, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>