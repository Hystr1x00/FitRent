<div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow border border-gray-100">
    <div class="relative h-48 bg-gradient-to-br {{ $bgFrom }} {{ $bgTo }}">
        <img src="{{ $img }}" class="w-full h-full object-cover" alt="{{ $sport }}">
        <div class="absolute top-4 right-4">
            <span class="px-3 py-1 bg-{{ $statusColor }}-500 text-white text-xs font-semibold rounded-full shadow-lg">{{ $status }}</span>
        </div>
        <div class="absolute top-4 left-4">
            <span class="px-3 py-1 bg-white text-gray-800 text-xs font-semibold rounded-full shadow-lg">{{ $sport }}</span>
        </div>
    </div>
    <div class="p-6">
        <div class="flex items-start justify-between mb-3">
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $title }}</h3>
                <p class="text-sm text-gray-500">Indoor • Rumput Sintetis</p>
            </div>
            <button class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-ellipsis-v"></i>
            </button>
        </div>
        <div class="space-y-2 mb-4">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600">Harga per Jam</span>
                <span class="font-bold text-primary-600">{{ $price }}</span>
            </div>
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600">Booking Bulan Ini</span>
                <span class="font-semibold text-gray-800">{{ $bookings }}</span>
            </div>
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600">Rating</span>
                <span class="flex items-center gap-1">
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                    <span class="font-semibold text-gray-800">{{ $rating }}</span>
                    <span class="text-gray-500">{{ $ratingCount }}</span>
                </span>
            </div>
        </div>
        <div class="flex gap-2">
            <button class="flex-1 px-4 py-2 bg-primary-50 text-primary-600 rounded-lg hover:bg-primary-100 transition font-medium text-sm">
                <i class="fas fa-edit mr-1"></i>
                Edit
            </button>
            <button class="flex-1 px-4 py-2 bg-gray-50 text-gray-700 rounded-lg hover:bg-gray-100 transition font-medium text-sm">
                <i class="fas fa-eye mr-1"></i>
                Detail
            </button>
        </div>
    </div>
</div>


