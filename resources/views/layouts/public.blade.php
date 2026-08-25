<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Website Resmi ' . ($settings->nama_sekolah ?? 'SMK Idrisiyyah') . ' - Mencetak generasi unggul, berkarakter dan menguasai teknologi.')">
    <meta property="og:title" content="@yield('title', $settings->nama_sekolah ?? 'SMK Idrisiyyah')">
    <meta property="og:description" content="@yield('meta_description', 'Website Resmi ' . ($settings->nama_sekolah ?? 'SMK Idrisiyyah') . ' - Mencetak generasi unggul, berkarakter dan menguasai teknologi.')">
    <meta property="og:image" content="@yield('meta_image', asset('assets/images/' . ($settings->logo ?? 'logo.png')))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    <title>@yield('title', $settings->nama_sekolah ?? 'SMK Idrisiyyah')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 900: '#1e3a8a', 950: '#172554',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    
    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 bg-slate-50 flex flex-col min-h-screen">

    <!-- Top Bar -->
    <div class="bg-brand-950 text-white/80 py-2 text-sm hidden md:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center space-x-6">
                @if(!empty($settings->email))
                <a href="mailto:{{ $settings->email }}" class="hover:text-white transition-colors duration-300 flex items-center gap-2">
                    <i class="fa-regular fa-envelope"></i> {{ $settings->email }}
                </a>
                @endif
                @if(!empty($settings->telepon))
                <a href="tel:{{ $settings->telepon }}" class="hover:text-white transition-colors duration-300 flex items-center gap-2">
                    <i class="fa-solid fa-phone"></i> {{ $settings->telepon }}
                </a>
                @endif
            </div>
            <div class="flex items-center space-x-4">
                <a href="/admin" class="hover:text-white transition-colors duration-300 font-medium">Login Panel</a>
                @if($settings->header_pendaftaran_aktif ?? false)
                <a href="{{ $settings->header_pendaftaran_url }}" class="bg-amber-500 hover:bg-amber-400 text-white px-4 py-1 rounded-full font-medium transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg shadow-amber-500/30">
                    {{ $settings->header_pendaftaran_teks ?: 'Pendaftaran' }}
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="glass-nav sticky top-0 z-50 w-full transition-all duration-300 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-3 group">
                        @if(!empty($settings->logo))
                        <img src="{{ asset('assets/images/' . $settings->logo) }}" alt="Logo" class="h-12 w-auto transform transition duration-500 group-hover:scale-105">
                        @else
                        <div class="h-12 w-12 bg-brand-600 text-white rounded-xl flex items-center justify-center font-bold text-xl shadow-lg shadow-brand-500/30">
                            {{ substr($settings->nama_sekolah ?? 'S', 0, 1) }}
                        </div>
                        @endif
                        <span class="font-bold text-xl md:text-2xl tracking-tight text-brand-900 group-hover:text-brand-600 transition-colors">
                            {{ $settings->nama_sekolah ?? 'SMK Idrisiyyah' }}
                        </span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex md:items-center md:space-x-8">
                    @foreach($menus as $menu)
                        @if($menu->children->count() > 0)
                        <div class="relative group py-2">
                            <button class="flex items-center gap-1 text-gray-600 hover:text-brand-600 font-medium transition-colors focus:outline-none">
                                {{ $menu->nama_menu }}
                                <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 group-hover:rotate-180"></i>
                            </button>
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-brand-600 transition-all duration-300 group-hover:w-full"></span>
                            
                            <!-- Dropdown -->
                            <div class="absolute left-0 top-full mt-1 w-48 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top -translate-y-2 group-hover:translate-y-0 z-50">
                                <div class="py-2">
                                    @foreach($menu->children as $child)
                                    <a href="{{ url($child->url) }}" target="{{ $child->target }}" class="block px-4 py-2 text-sm text-gray-600 hover:text-brand-600 hover:bg-brand-50 transition-colors">
                                        {{ $child->nama_menu }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @else
                        <a href="{{ url($menu->url) }}" target="{{ $menu->target }}" class="text-gray-600 hover:text-brand-600 font-medium transition-colors relative group py-2">
                            {{ $menu->nama_menu }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-brand-600 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-brand-950 pt-16 pb-8 border-t-[6px] border-brand-500 text-slate-300 mt-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-500">
                <p>&copy; {{ date('Y') }} {{ $settings->nama_sekolah ?? 'SMK Idrisiyyah' }}. All rights reserved.</p>
                <p>Designed with ❤️ for Education</p>
            </div>
        </div>
    </footer>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    @stack('scripts')
</body>
</html>