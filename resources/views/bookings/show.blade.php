<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Booking Details
            </h2>
            <a href="{{ route('bookings.index') }}" class="text-indigo-600 hover:text-indigo-800">
                ← Back to Bookings
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <div class="pt-24 pb-16 px-4">
            <div class="max-w-4xl mx-auto">
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Booking Details -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="p-6">
                                <!-- Venue Info -->
                                <div class="flex items-center mb-6">
                                    <img src="{{ $booking->slot->venue->image }}" alt="{{ $booking->slot->venue->name }}" 
                                         class="w-20 h-20 object-cover rounded-lg mr-4">
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-900">{{ $booking->slot->venue->name }}</h3>
                                        <p class="text-gray-600">{{ $booking->slot->venue->location }}</p>
                                        <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm font-semibold mt-1">
                                            {{ $booking->slot->sport }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Booking Info -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-3">Booking Information</h4>
                                        <div class="space-y-2">
                                            <div class="flex items-center text-sm">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span class="text-gray-600">Date:</span>
                                                <span class="ml-2 font-medium">{{ $booking->slot->date->format('d M Y') }}</span>
                                            </div>
                                            <div class="flex items-center text-sm">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="text-gray-600">Time:</span>
                                                <span class="ml-2 font-medium">{{ \Carbon\Carbon::parse($booking->slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->slot->end_time)->format('H:i') }}</span>
                                            </div>
                                            <div class="flex items-center text-sm">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                <span class="text-gray-600">Participants:</span>
                                                <span class="ml-2 font-medium">{{ $booking->slot->current_participants }}/{{ $booking->slot->max_participants }}</span>
                                            </div>
                                            <div class="flex items-center text-sm">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="text-gray-600">Status:</span>
                                                <span class="ml-2 font-medium">
                                                    @if($booking->status === 'confirmed')
                                                        <span class="text-green-600">Confirmed</span>
                                                    @elseif($booking->status === 'pending')
                                                        <span class="text-yellow-600">Pending</span>
                                                    @else
                                                        <span class="text-red-600">Cancelled</span>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-3">Slot Creator</h4>
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $booking->slot->creator->name }}</p>
                                                <p class="text-sm text-gray-600">{{ $booking->slot->creator->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Participants List -->
                                @if($booking->slot->participants->count() > 0)
                                    <div class="mb-6">
                                        <h4 class="font-semibold text-gray-900 mb-3">Participants</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            @foreach($booking->slot->participants as $participant)
                                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-gray-900">{{ $participant->name }}</p>
                                                        <p class="text-sm text-gray-600">{{ $participant->email }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Actions -->
                                <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                                    <div>
                                        @if($booking->status === 'pending')
                                            <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                Cancel Booking
                                            </button>
                                        @endif
                                    </div>
                                    <div class="flex space-x-3">
                                        <a href="{{ route('venues.show', $booking->slot->venue) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                            View Venue
                                        </a>
                                        <button class="text-gray-600 hover:text-gray-800 font-medium">
                                            Download Receipt
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow-md sticky top-6">
                            <div class="p-6">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Payment Summary</h4>
                                
                                <div class="space-y-3">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Venue Price</span>
                                        <span class="font-medium">Rp {{ number_format($booking->slot->venue->price, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Service Fee</span>
                                        <span class="font-medium">Rp 10,000</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Tax</span>
                                        <span class="font-medium">Rp 5,000</span>
                                    </div>
                                    <div class="border-t pt-3">
                                        <div class="flex justify-between font-semibold">
                                            <span>Total</span>
                                            <span>Rp {{ number_format($booking->slot->venue->price + 15000, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <h5 class="font-semibold text-gray-900 mb-2">Payment Method</h5>
                                    <p class="text-sm text-gray-600">Credit Card ending in 4242</p>
                                </div>
                                
                                <div class="mt-4">
                                    <h5 class="font-semibold text-gray-900 mb-2">Booking ID</h5>
                                    <p class="text-sm text-gray-600 font-mono">{{ $booking->id }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>