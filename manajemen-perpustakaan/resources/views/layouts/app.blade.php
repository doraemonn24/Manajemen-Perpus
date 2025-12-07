<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Taman Buku - Perpustakaan Digital Ajaib')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700,800,900|dancing-script:400,500,600,700|inter:300,400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            :root {
                --primary-pink: #ec4899;
                --primary-purple: #a855f7;
                --primary-blue: #0ea5e9;
            }
            
            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(135deg, #fdf2f8 0%, #f5f3ff 50%, #eff6ff 100%);
                min-height: 100vh;
            }
            
            .font-serif {
                font-family: 'Playfair Display', serif;
            }
            
            .font-cursive {
                font-family: 'Dancing Script', cursive;
            }
            
            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 10px;
            }
            
            ::-webkit-scrollbar-track {
                background: #fce7f3;
                border-radius: 10px;
            }
            
            ::-webkit-scrollbar-thumb {
                background: linear-gradient(to bottom, var(--primary-pink), var(--primary-purple));
                border-radius: 10px;
                border: 2px solid #fdf2f8;
            }
            
            ::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(to bottom, #db2777, #9333ea);
            }
            
            /* Page Transitions */
            .page-transition {
                animation: fadeIn 0.5s ease-in-out;
            }
            
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            /* Floating Animation */
            @keyframes float {
                0%, 100% {
                    transform: translateY(0px);
                }
                50% {
                    transform: translateY(-15px);
                }
            }
            
            .floating {
                animation: float 4s ease-in-out infinite;
            }
            
            /* Glow Animation */
            @keyframes glow {
                0%, 100% {
                    opacity: 0.5;
                }
                50% {
                    opacity: 0.8;
                }
            }
            
            .glow {
                animation: glow 2s ease-in-out infinite;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="min-h-screen page-transition">
            <!-- Navigation -->
            <nav class="bg-white/80 backdrop-blur-lg border-b border-pink-100 sticky top-0 z-50 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-20">
                        <div class="flex items-center">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <a href="{{ url('/') }}" class="flex items-center space-x-4 group">
                                    <div class="relative">
                                        <div class="w-14 h-14 bg-gradient-to-br from-pink-400 to-purple-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-2xl transition-all duration-300 group-hover:scale-105">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        <!-- Sparkle effect -->
                                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-yellow-300 rounded-full animate-ping"></div>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-2xl font-bold text-gray-900 font-serif">Taman Buku</span>
                                        <span class="text-xs text-purple-600 font-cursive font-semibold">Perpustakaan Ajaib</span>
                                    </div>
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-1 sm:-my-px sm:ml-10 sm:flex">
                                <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="px-5 py-2 rounded-lg transition-all duration-300 hover:bg-pink-50 group">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-pink-400 group-hover:text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                        <span class="font-medium">Home</span>
                                    </div>
                                </x-nav-link>
                                <x-nav-link :href="route('books.index')" :active="request()->routeIs('books.index')" class="px-5 py-2 rounded-lg transition-all duration-300 hover:bg-purple-50 group">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-purple-400 group-hover:text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        <span class="font-medium">Katalog</span>
                                    </div>
                                </x-nav-link>
                                <x-nav-link :href="route('about')" :active="request()->routeIs('about')" class="px-5 py-2 rounded-lg transition-all duration-300 hover:bg-blue-50 group">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="font-medium">Tentang</span>
                                    </div>
                                </x-nav-link>
                            </div>
                        </div>

                        <!-- Right Navigation -->
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            @auth
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none transition-all duration-300 group">
                                            <div class="relative">
                                                <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold text-sm group-hover:scale-105 transition-transform shadow-lg">
                                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                                </div>
                                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-blue-400 rounded-full border-2 border-white"></div>
                                            </div>
                                            <div class="ml-3 flex flex-col items-start">
                                                <span class="font-semibold">{{ Auth::user()->name }}</span>
                                                <span class="text-xs text-purple-500">Penjelajah</span>
                                            </div>
                                            <svg class="ml-3 -mr-0.5 h-5 w-5 text-gray-400 group-hover:text-pink-500 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <div class="p-4 border-b border-pink-100 bg-gradient-to-r from-pink-50 to-purple-50">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 bg-gradient-to-br from-pink-400 to-purple-500 rounded-full flex items-center justify-center text-white text-sm">
                                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                                    <p class="text-xs text-purple-500">Penjelajah Taman</p>
                                                </div>
                                            </div>
                                        </div>
                                        <x-dropdown-link :href="route('dashboard')" class="flex items-center gap-3 px-4 py-3 hover:bg-pink-50 transition-colors">
                                            <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                            {{ __('Dashboard') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-3 px-4 py-3 hover:bg-purple-50 transition-colors">
                                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            {{ __('Profile') }}
                                        </x-dropdown-link>
                                        <div class="p-2 border-t border-pink-100">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <x-dropdown-link :href="route('logout')"
                                                        onclick="event.preventDefault();
                                                                    this.closest('form').submit();"
                                                        class="flex items-center gap-3 px-4 py-3 hover:bg-red-50 text-pink-600 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                    </svg>
                                                    {{ __('Keluar') }}
                                                </x-dropdown-link>
                                            </form>
                                        </div>
                                    </x-slot>
                                </x-dropdown>
                            @else
                                <div class="flex items-center space-x-6">
                                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-pink-600 font-medium transition-all duration-300 flex items-center gap-2 group">
                                        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                        </svg>
                                        <span class="font-medium">{{ __('Masuk') }}</span>
                                    </a>
                                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-7 py-3 rounded-xl hover:from-pink-600 hover:to-purple-700 font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl active:scale-95 flex items-center gap-2 group relative overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-r from-pink-600 to-purple-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <svg class="w-5 h-5 text-white relative z-10 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                        </svg>
                                        <span class="relative z-10 font-medium">{{ __('Daftar') }}</span>
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="flex-1">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-gradient-to-br from-white to-pink-50 border-t border-pink-100 mt-20 relative overflow-hidden">
                <!-- Floating elements -->
                <div class="absolute top-0 left-10 w-6 h-6 bg-pink-200 rounded-full opacity-30 floating" style="animation-delay: 0.2s;"></div>
                <div class="absolute top-10 right-20 w-4 h-4 bg-purple-200 rounded-full opacity-40 floating" style="animation-delay: 0.5s;"></div>
                <div class="absolute bottom-20 left-1/4 w-5 h-5 bg-blue-200 rounded-full opacity-30 floating" style="animation-delay: 0.8s;"></div>
                
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div>
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-purple-500 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xl font-bold text-gray-900 font-serif">Taman Buku</span>
                                    <p class="text-xs text-purple-600 font-cursive">Dimana mimpi bertemu kenyataan</p>
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm">
                                Taman ajaib berisi ribuan buku untuk membawa Anda ke dunia fantasi, petualangan, dan pengetahuan tanpa batas.
                            </p>
                        </div>
                        
                        <div>
                            <h3 class="font-bold text-lg mb-4 font-serif text-gray-800">🌿 Jelajahi</h3>
                            <ul class="space-y-3">
                                <li><a href="{{ route('books.index') }}" class="text-gray-600 hover:text-pink-500 transition-colors flex items-center gap-2">
                                    <span class="text-xs">🌸</span> Katalog Buku
                                </a></li>
                                <li><a href="{{ route('about') }}" class="text-gray-600 hover:text-purple-500 transition-colors flex items-center gap-2">
                                    <span class="text-xs">✨</span> Tentang Kami
                                </a></li>
                                <li><a href="#" class="text-gray-600 hover:text-blue-500 transition-colors flex items-center gap-2">
                                    <span class="text-xs">📖</span> Panduan
                                </a></li>
                            </ul>
                        </div>
                        
                        <div>
                            <h3 class="font-bold text-lg mb-4 font-serif text-gray-800">🌼 Kategori</h3>
                            <ul class="space-y-3">
                                <li><a href="#" class="text-gray-600 hover:text-pink-500 transition-colors">Fantasi & Ajaib</a></li>
                                <li><a href="#" class="text-gray-600 hover:text-purple-500 transition-colors">Fiksi, Non-Fiksi</a></li>
                                <li><a href="#" class="text-gray-600 hover:text-blue-500 transition-colors">Pengetahuan</a></li>
                                <li><a href="#" class="text-gray-600 hover:text-pink-500 transition-colors">Novel, Biografi, Teknologi</a></li>
                            </ul>
                        </div>
                        
                        <div>
                            <h3 class="font-bold text-lg mb-4 font-serif text-gray-800">🦋 Hubungi</h3>
                            <p class="text-gray-600 text-sm mb-4">
                                Butuh bantuan peri taman? Kami siap membantu!
                            </p>
                            <div class="flex space-x-3">
                                <a href="#" class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center hover:bg-pink-200 transition-colors group">
                                    <svg class="w-5 h-5 text-pink-500 group-hover:text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
                                    </svg>
                                </a>
                                <a href="#" class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center hover:bg-purple-200 transition-colors group">
                                    <svg class="w-5 h-5 text-purple-500 group-hover:text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path>
                                    </svg>
                                </a>
                                <a href="#" class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center hover:bg-blue-200 transition-colors group">
                                    <svg class="w-5 h-5 text-blue-500 group-hover:text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-t border-pink-200 mt-8 pt-8 text-center">
                        <p class="text-gray-500 text-sm font-cursive">
                            "Setiap buku adalah jendela ke taman imajinasi" 
                            <span class="block mt-2 text-xs text-gray-400">
                                &copy; {{ date('Y') }} Taman Buku - Perpustakaan Digital Ajaib
                            </span>
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>