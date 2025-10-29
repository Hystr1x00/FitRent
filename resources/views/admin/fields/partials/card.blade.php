<div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 border border-gray-200 group">
    <!-- Image Section with Overlay -->
    <div class="relative h-48 bg-gradient-to-br {{ $bgFrom }} {{ $bgTo }} overflow-hidden">
        <img src="{{ $img }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="{{ $sport }}">
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
        
        <!-- Status Badge -->
        <div class="absolute top-3 right-3">
            <span class="px-3 py-1.5 bg-{{ $statusColor }}-500 text-white text-xs font-semibold rounded-lg shadow-lg backdrop-blur-sm">
                {{ $status }}
            </span>
        </div>
        
        <!-- Sport Badge -->
        <div class="absolute top-3 left-3">
            <span class="px-3 py-1.5 bg-white/95 backdrop-blur-sm text-gray-800 text-xs font-semibold rounded-lg shadow-lg flex items-center gap-1.5">
                <i class="fas fa-{{ $sport === 'Futsal' ? 'futbol' : ($sport === 'Padel' ? 'table-tennis-paddle-ball' : 'volleyball') }} text-blue-600"></i>
                {{ $sport }}
            </span>
        </div>
    </div>
    
    <!-- Content Section -->
    <div class="p-5">
        <!-- Header -->
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-blue-600 transition-colors">
                    {{ $title }}
                </h3>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <span class="inline-flex items-center gap-1">
                        <i class="fas fa-house text-gray-400"></i>
                        Indoor
                    </span>
                    <span class="text-gray-300">•</span>
                    <span class="inline-flex items-center gap-1">
                        <i class="fas fa-leaf text-gray-400"></i>
                        Rumput Sintetis
                    </span>
                </div>
            </div>
            <button class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <i class="fas fa-ellipsis-v"></i>
            </button>
        </div>
        
        <!-- Stats -->
        <div class="space-y-2.5 mb-5 pb-5 border-b border-gray-100">
            <!-- Price -->
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 font-medium">Harga per Jam</span>
                <span class="font-bold text-blue-600 text-base">{{ $price }}</span>
            </div>
            
            <!-- Bookings -->
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 font-medium">Booking Bulan Ini</span>
                <span class="font-semibold text-gray-900">{{ $bookings }}</span>
            </div>
            
            <!-- Rating -->
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 font-medium">Rating</span>
                <span class="flex items-center gap-1.5">
                    <i class="fas fa-star text-yellow-400 text-sm"></i>
                    <span class="font-semibold text-gray-900">{{ $rating }}</span>
                    <span class="text-gray-500 text-sm">{{ $ratingCount }}</span>
                </span>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex gap-2">
            <a href="{{ route('admin.fields.edit', $court) }}" 
               class="flex-1 px-4 py-2.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors font-medium text-sm text-center inline-flex items-center justify-center gap-2 group/btn">
                <i class="fas fa-edit text-xs group-hover/btn:scale-110 transition-transform"></i>
                Edit
            </a>
            <form action="{{ isset($court) ? route('admin.fields.destroy', $court) : '#' }}" 
                  method="POST" 
                  onsubmit="return confirm('Hapus lapangan ini?')" 
                  class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="w-full px-4 py-2.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors font-medium text-sm inline-flex items-center justify-center gap-2 group/btn">
                    <i class="fas fa-trash text-xs group-hover/btn:scale-110 transition-transform"></i>
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>