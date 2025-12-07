@extends('mahasiswa.app')

@section('title', 'Tulis Ulasan Buku')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-pink-100">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-pink-400 to-purple-500 rounded-xl flex items-center justify-center">
                    <span class="text-white text-xl">⭐</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Tulis Ulasan</h1>
            </div>
            <p class="text-gray-600 mb-2">Bagikan pengalaman Anda membaca buku:</p>
            <div class="p-4 bg-gradient-to-r from-pink-50 to-purple-50 rounded-xl border border-pink-200">
                <p class="font-medium text-gray-800">"{{ $loan->book->judul }}"</p>
                <p class="text-sm text-gray-500 mt-1">oleh {{ $loan->book->penulis }}</p>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('mahasiswa.loans.review.store', $loan->id) }}" method="POST">
            @csrf

            <!-- Rating -->
            <div class="mb-8">
                <label for="rating" class="block mb-3 text-gray-700 font-medium">Beri Rating (1-5)</label>
                <div class="flex items-center gap-6">
                    <input type="number" 
                           name="rating" 
                           id="rating" 
                           min="1" 
                           max="5" 
                           value="{{ old('rating') }}"
                           class="px-5 py-3 border-2 border-pink-200 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-pink-300 outline-none transition w-24 text-center text-lg font-bold">
                    <div class="flex items-center gap-1">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="text-2xl {{ old('rating') >= $i ? 'text-yellow-400' : 'text-gray-300' }}" id="star-{{ $i }}">★</span>
                        @endfor
                    </div>
                </div>
                @error('rating')
                    <p class="text-pink-500 text-sm mt-2 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Komentar -->
            <div class="mb-10">
                <label for="komentar" class="block mb-3 text-gray-700 font-medium">Komentar Ulasan</label>
                <textarea name="komentar" 
                          id="komentar" 
                          rows="5" 
                          class="w-full px-5 py-4 border-2 border-purple-200 rounded-xl focus:ring-2 focus:ring-purple-300 focus:border-purple-300 outline-none transition bg-white resize-none"
                          placeholder="Bagikan pengalaman membaca Anda...">{{ old('komentar') }}</textarea>
                @error('komentar')
                    <p class="text-purple-500 text-sm mt-2 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('mahasiswa.loans.show', $loan->id) }}">
                    <button type="button" 
                            class="px-6 py-3 bg-gradient-to-r from-gray-400 to-gray-500 text-white rounded-xl hover:from-gray-500 hover:to-gray-600 transition-all duration-300 shadow hover:shadow-lg flex items-center gap-2">
                        <span>↩️</span> Batal
                    </button>
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-xl hover:from-pink-600 hover:to-purple-700 transition-all duration-300 shadow hover:shadow-lg flex items-center gap-2">
                    <span>📤</span> Kirim Ulasan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Star Rating Interactive Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ratingInput = document.getElementById('rating');
    const stars = document.querySelectorAll('[id^="star-"]');
    
    // Update stars based on input
    ratingInput.addEventListener('input', function() {
        const value = parseInt(this.value);
        stars.forEach((star, index) => {
            if (index < value) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });
    });
    
    // Click stars to set rating
    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            const rating = index + 1;
            ratingInput.value = rating;
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-yellow-400');
                } else {
                    s.classList.remove('text-yellow-400');
                    s.classList.add('text-gray-300');
                }
            });
        });
    });
    
    // Hover effect for stars
    stars.forEach((star, index) => {
        star.addEventListener('mouseenter', function() {
            const hoverRating = index + 1;
            stars.forEach((s, i) => {
                if (i < hoverRating) {
                    s.classList.add('text-yellow-300');
                }
            });
        });
        
        star.addEventListener('mouseleave', function() {
            const currentRating = parseInt(ratingInput.value) || 0;
            stars.forEach((s, i) => {
                if (i >= currentRating) {
                    s.classList.remove('text-yellow-300');
                }
            });
        });
    });
});
</script>
@endsection