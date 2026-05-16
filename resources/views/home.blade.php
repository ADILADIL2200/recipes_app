<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuisto — Recipes Worth Making</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['Playfair Display', 'serif'],
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#fdf6f3',
                            100: '#f5ede7',
                            200: '#e8d5c8',
                            300: '#d4b8a4',
                            400: '#c4957a',
                            500: '#b84a1c',
                            600: '#a03d15',
                            700: '#7a2e10',
                            800: '#5a220c',
                            900: '#3d1708',
                        },
                        warm: {
                            50: '#faf8f5',
                            100: '#f5f0ea',
                            200: '#e8e0d4',
                            300: '#d4c8b8',
                            400: '#b8a898',
                            500: '#9a8e7e',
                            600: '#7a6e5e',
                            700: '#5a4e3c',
                            800: '#3d3528',
                            900: '#18140e',
                        },
                        sage: {
                            50: '#f0f5ee',
                            100: '#eaf2e8',
                            200: '#c8d9c2',
                            300: '#a3bf9a',
                            400: '#7aa370',
                            500: '#3d5c36',
                            600: '#334d2d',
                            700: '#2a3f25',
                        },
                        gold: {
                            50: '#fef9f0',
                            100: '#fef6e4',
                            200: '#f5e4b8',
                            300: '#ecd18a',
                            400: '#e0bc5c',
                            500: '#c8972a',
                            600: '#a87d1f',
                            700: '#8a6619',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-mesh {
            background:
                radial-gradient(ellipse at 20% 50%, rgba(184, 74, 28, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(61, 92, 54, 0.06) 0%, transparent 50%),
                radial-gradient(ellipse at 60% 80%, rgba(200, 151, 42, 0.06) 0%, transparent 50%),
                linear-gradient(180deg, #faf8f5 0%, #f5f0ea 100%);
        }
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 50px -12px rgba(24, 20, 14, 0.15);
        }
        .image-zoom {
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover .image-zoom {
            transform: scale(1.08);
        }
        .chip-hover {
            transition: all 0.3s ease;
        }
        .chip-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(184, 74, 28, 0.2);
        }
        .btn-shine {
            position: relative;
            overflow: hidden;
        }
        .btn-shine::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        .btn-shine:hover::after {
            left: 100%;
        }
        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
            opacity: 0;
        }
        @keyframes fadeIn {
            to { opacity: 1; }
        }
        .slide-up {
            animation: slideUp 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        @keyframes slideUp {
            to { opacity: 1; transform: translateY(0); }
        }
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .text-balance {
            text-wrap: balance;
        }
    </style>

</head>
<body class="font-sans text-warm-900 gradient-mesh min-h-screen">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="fixed top-4 left-1/2 -translate-x-1/2 z-[300] bg-sage-500 text-white px-6 py-3 rounded-full shadow-lg font-medium text-sm fade-in flex items-center gap-2">
        <i data-lucide="check-circle" class="w-4 h-4"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- Navigation --}}
    <nav class="sticky top-0 z-[200] glass border-b border-warm-200/60">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-serif text-2xl font-bold text-brand-500 tracking-tight hover:text-brand-600 transition-colors">
                Cuisto
            </a>
            <div class="flex items-center gap-6">
                <a href="{{ route('recipes.search') }}" class="text-warm-600 hover:text-brand-500 text-sm font-medium transition-colors hidden sm:block">Parcourir</a>
                @auth
                    <a href="{{ route('recipes.my') }}" class="text-warm-600 hover:text-brand-500 text-sm font-medium transition-colors hidden sm:block">Mes recettes</a>
                    <a href="{{ route('recipes.create') }}" class="btn-shine bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium px-5 py-2.5 rounded-full transition-colors flex items-center gap-2">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        <span class="hidden sm:inline">Nouvelle recette</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-warm-500 hover:text-warm-700 text-sm font-medium transition-colors flex items-center gap-1.5">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            <span class="hidden sm:inline">Déconnexion</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-warm-600 hover:text-brand-500 text-sm font-medium transition-colors">Connexion</a>
                    <a href="{{ route('signup') }}" class="btn-shine bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium px-5 py-2.5 rounded-full transition-colors">
                        Rejoindre
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Admin Panel --}}
    @auth
    @if(Auth::user()->role === 'admin')
    <div class="max-w-7xl mx-auto px-6 lg:px-8 pt-8">
        <div class="bg-warm-900 rounded-2xl p-6 lg:p-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-brand-500/10 rounded-full -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-gold-500/10 rounded-full translate-y-1/2 -translate-x-1/3"></div>
            <div class="relative z-10">
                <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                    <div>
                        <h3 class="font-serif text-xl font-semibold">Admin Dashboard</h3>
                        <p class="text-warm-400 text-sm mt-1">Live platform overview</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.dashboard') }}" class="bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium px-4 py-2 rounded-full transition-colors flex items-center gap-2">
                            <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                            Manage recipes
                        </a>
                        <a href="{{ route('admin.users') }}" class="bg-white/10 hover:bg-white/20 text-white/90 text-sm font-medium px-4 py-2 rounded-full transition-colors flex items-center gap-2">
                            <i data-lucide="users" class="w-4 h-4"></i>
                            Manage users
                        </a>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-px bg-white/10 rounded-xl overflow-hidden">
                    @php
                        $adminStats = [
                            ['num' => $stats['total_recipes'], 'lbl' => 'Recipes', 'icon' => 'book-open'],
                            ['num' => $stats['pending_recipes'], 'lbl' => 'Pending', 'icon' => 'clock'],
                            ['num' => $stats['total_users'], 'lbl' => 'Users', 'icon' => 'users'],
                            ['num' => $stats['total_ratings'], 'lbl' => 'Ratings', 'icon' => 'star'],
                            ['num' => $stats['total_categories'], 'lbl' => 'Categories', 'icon' => 'grid-3x3'],
                            ['num' => $stats['total_tags'], 'lbl' => 'Tags', 'icon' => 'tag'],
                        ];
                    @endphp
                    @foreach($adminStats as $stat)
                    <div class="bg-warm-900/80 p-4 text-center">
                        <div class="flex justify-center mb-2">
                            <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5 text-gold-400"></i>
                        </div>
                        <div class="font-serif text-2xl font-semibold text-gold-400">{{ $stat['num'] }}</div>
                        <div class="text-xs text-warm-400 uppercase tracking-wider mt-1">{{ $stat['lbl'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
    @endauth

    {{-- Guest Hero --}}
    @guest
    <section class="max-w-7xl mx-auto px-6 lg:px-8 pt-12 lg:pt-20 pb-16">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div class="slide-up">
                <div class="inline-flex items-center gap-2 bg-brand-100 text-brand-600 text-xs font-semibold uppercase tracking-widest px-4 py-2 rounded-full mb-6">
                    <span class="w-1.5 h-1.5 bg-brand-500 rounded-full"></span>
                    {{ $stats['total_recipes'] }}+ recipes live
                </div>
                <h1 class="font-serif text-5xl lg:text-7xl font-medium leading-[1.1] text-balance mb-6">
                    Recipes you'll <em class="text-brand-500">love</em> to make again.
                </h1>
                <p class="text-warm-600 text-lg leading-relaxed max-w-md mb-8 text-balance">
                    Discover home-cooked recipes shared by real cooks — from quick weeknight dinners to long weekend feasts.
                </p>
                <div class="flex flex-wrap gap-4 mb-12">
                    <a href="{{ route('signup') }}" class="btn-shine bg-brand-500 hover:bg-brand-600 text-white font-medium px-8 py-3.5 rounded-full transition-colors inline-flex items-center gap-2">
                        Start cooking
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ route('recipes.index') }}" class="bg-white hover:bg-warm-50 text-warm-700 border border-warm-200 font-medium px-8 py-3.5 rounded-full transition-colors inline-flex items-center gap-2">
                        <i data-lucide="search" class="w-4 h-4"></i>
                        Parcourir recipes
                    </a>
                </div>
                <div class="flex gap-8 pt-8 border-t border-warm-200">
                    @php $heroStats = [
                        ['num' => $stats['total_recipes'], 'lbl' => 'Recipes'],
                        ['num' => $stats['total_users'], 'lbl' => 'Cooks'],
                        ['num' => $stats['total_ratings'], 'lbl' => 'Reviews'],
                        ['num' => $stats['total_categories'], 'lbl' => 'Categories'],
                    ]; @endphp
                    @foreach($heroStats as $stat)
                    <div>
                        <div class="font-serif text-3xl font-semibold text-brand-500">{{ $stat['num'] }}</div>
                        <div class="text-xs text-warm-500 uppercase tracking-wider mt-1">{{ $stat['lbl'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="relative slide-up stagger-2 hidden lg:block">
                <div class="aspect-[3/4] rounded-3xl overflow-hidden bg-gradient-to-br from-warm-200 to-warm-300 relative">
                    <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=800&q=80"
                         alt="Cooking"
                         class="w-full h-full object-cover image-zoom">
                    <div class="absolute inset-0 bg-gradient-to-t from-warm-900/30 to-transparent"></div>
                </div>
                <div class="absolute -bottom-4 -left-4 bg-white rounded-2xl p-4 shadow-xl border border-warm-100 flex items-center gap-3">
                    <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="star" class="w-6 h-6 text-brand-500 fill-brand-500"></i>
                    </div>
                    <div>
                        <div class="text-xs text-warm-500 uppercase tracking-wider">Top rated today</div>
                        <div class="font-serif text-xl font-semibold">4.9 / 5.0</div>
                    </div>
                </div>
                <div class="absolute top-6 -right-3 bg-brand-500 text-white px-4 py-2 rounded-full text-sm font-semibold flex items-center gap-2 shadow-lg">
                    <i data-lucide="flame" class="w-4 h-4 fill-white"></i>
                    Trending now
                </div>
            </div>
        </div>
    </section>
    @endguest

    {{-- How It Works --}}
    @guest
    <section class="max-w-7xl mx-auto px-6 lg:px-8 pt-16 pb-8">
        <div class="text-center mb-12">
            <span class="inline-flex items-center gap-2 bg-sage-100 text-sage-600 text-xs font-semibold uppercase tracking-widest px-4 py-2 rounded-full mb-4">
                <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                How it works
            </span>
            <h2 class="font-serif text-3xl lg:text-4xl font-semibold mb-4">Three steps to culinary fame</h2>
            <p class="text-warm-500 max-w-lg mx-auto">Share your favorite recipes with thousands of home cooks around the world. It's simple, free, and rewarding.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl p-8 border border-warm-200/60 text-center group hover:border-brand-300 transition-colors">
                <div class="w-16 h-16 bg-brand-100 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-brand-500 transition-colors">
                    <i data-lucide="user-plus" class="w-7 h-7 text-brand-500 group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="font-serif text-xl font-semibold mb-2">Create your profile</h3>
                <p class="text-warm-500 text-sm leading-relaxed">Sign up in seconds and set up your personal kitchen profile. No credit card required.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 border border-warm-200/60 text-center group hover:border-brand-300 transition-colors">
                <div class="w-16 h-16 bg-brand-100 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-brand-500 transition-colors">
                    <i data-lucide="pen-tool" class="w-7 h-7 text-brand-500 group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="font-serif text-xl font-semibold mb-2">Share recipes</h3>
                <p class="text-warm-500 text-sm leading-relaxed">Write down your recipes with photos, ingredients, and step-by-step instructions.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 border border-warm-200/60 text-center group hover:border-brand-300 transition-colors">
                <div class="w-16 h-16 bg-brand-100 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-brand-500 transition-colors">
                    <i data-lucide="trophy" class="w-7 h-7 text-brand-500 group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="font-serif text-xl font-semibold mb-2">Get discovered</h3>
                <p class="text-warm-500 text-sm leading-relaxed">Earn ratings, build a following, and become a trusted voice in the cooking community.</p>
            </div>
        </div>
    </section>
    @endguest

    {{-- Featured Cooks --}}
    @guest
    <section class="max-w-7xl mx-auto px-6 lg:px-8 pt-16 pb-8">
        <div class="flex items-baseline justify-between mb-8 pb-4 border-b border-warm-200">
            <div>
                <span class="text-warm-500 text-xs font-semibold uppercase tracking-widest mb-2 block">Community</span>
                <h2 class="font-serif text-3xl font-semibold">Meet our top cooks</h2>
            </div>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $featuredCooks = [
                    ['name' => 'Maria Chen', 'recipes' => 47, 'followers' => '12.5K', 'specialty' => 'Asian Fusion', 'avatar' => 'MC'],
                    ['name' => 'James O\'Brien', 'recipes' => 32, 'followers' => '8.2K', 'specialty' => 'BBQ & Grill', 'avatar' => 'JO'],
                    ['name' => 'Sofia Rossi', 'recipes' => 56, 'followers' => '15.1K', 'specialty' => 'Italian Classics', 'avatar' => 'SR'],
                    ['name' => 'David Kim', 'recipes' => 28, 'followers' => '6.8K', 'specialty' => 'Vegan Delights', 'avatar' => 'DK'],
                ];
            @endphp
            @foreach($featuredCooks as $cook)
            <div class="bg-white rounded-2xl p-6 border border-warm-200/60 text-center hover:border-brand-300 transition-colors">
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-brand-200 to-brand-300 flex items-center justify-center mx-auto mb-4 text-brand-700 font-serif text-xl font-bold">
                    {{ $cook['avatar'] }}
                </div>
                <h3 class="font-serif text-lg font-semibold">{{ $cook['name'] }}</h3>
                <p class="text-brand-500 text-sm font-medium mt-1">{{ $cook['specialty'] }}</p>
                <div class="flex justify-center gap-6 mt-4 pt-4 border-t border-warm-100">
                    <div>
                        <div class="font-semibold text-warm-800">{{ $cook['recipes'] }}</div>
                        <div class="text-xs text-warm-500">Recipes</div>
                    </div>
                    <div>
                        <div class="font-semibold text-warm-800">{{ $cook['followers'] }}</div>
                        <div class="text-xs text-warm-500">Followers</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endguest

    {{-- Why Join --}}
    @guest
    <section class="max-w-7xl mx-auto px-6 lg:px-8 pt-16 pb-8">
        <div class="bg-warm-50 rounded-3xl p-8 lg:p-12 border border-warm-200/60">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="inline-flex items-center gap-2 bg-gold-100 text-gold-600 text-xs font-semibold uppercase tracking-widest px-4 py-2 rounded-full mb-4">
                        <i data-lucide="crown" class="w-3.5 h-3.5"></i>
                        Why Cuisto?
                    </span>
                    <h2 class="font-serif text-3xl lg:text-4xl font-semibold mb-6">Everything you need to share your passion for cooking</h2>
                    <div class="space-y-5">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 bg-brand-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="image" class="w-5 h-5 text-brand-500"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-warm-800">Beautiful recipe cards</h4>
                                <p class="text-warm-500 text-sm mt-1">Your recipes look stunning with our photo-first layout and clean typography.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-10 h-10 bg-sage-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="bar-chart-3" class="w-5 h-5 text-sage-500"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-warm-800">Track your growth</h4>
                                <p class="text-warm-500 text-sm mt-1">See detailed analytics on views, ratings, and follower growth over time.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-10 h-10 bg-gold-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="bookmark" class="w-5 h-5 text-gold-500"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-warm-800">Save & organize</h4>
                                <p class="text-warm-500 text-sm mt-1">Bookmark recipes you love and organize them into custom collections.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-10 h-10 bg-brand-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="message-circle" class="w-5 h-5 text-brand-500"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-warm-800">Engage with cooks</h4>
                                <p class="text-warm-500 text-sm mt-1">Receive feedback, answer questions, and build relationships with food lovers.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative hidden lg:block">
                    <div class="aspect-square rounded-3xl overflow-hidden bg-gradient-to-br from-warm-200 to-warm-300">
                        <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=800&q=80"
                             alt="Cooking together"
                             class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-6 -right-6 bg-white rounded-2xl p-5 shadow-xl border border-warm-100">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-sage-100 rounded-xl flex items-center justify-center">
                                <i data-lucide="trending-up" class="w-6 h-6 text-sage-500"></i>
                            </div>
                            <div>
                                <div class="text-xs text-warm-500 uppercase tracking-wider">Monthly growth</div>
                                <div class="font-serif text-xl font-semibold text-warm-800">+2,400 cooks</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endguest

    {{-- Testimonials --}}
    @guest
    <section class="max-w-7xl mx-auto px-6 lg:px-8 pt-16 pb-8">
        <div class="text-center mb-10">
            <span class="inline-flex items-center gap-2 bg-brand-100 text-brand-600 text-xs font-semibold uppercase tracking-widest px-4 py-2 rounded-full mb-4">
                <i data-lucide="quote" class="w-3.5 h-3.5"></i>
                Testimonials
            </span>
            <h2 class="font-serif text-3xl lg:text-4xl font-semibold">Loved by home cooks</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @php
                $testimonials = [
                    ['text' => "Cuisto transformed how I share my grandmother's recipes. The community is incredibly supportive and I've gained so many new friends who love cooking as much as I do.", 'author' => 'Elena Rodriguez', 'role' => 'Home Cook', 'location' => 'Barcelona'],
                    ['text' => "I started sharing recipes as a hobby and now I have over 10,000 followers. The platform makes it so easy to format recipes beautifully and track engagement.", 'author' => 'Marcus Johnson', 'role' => 'Food Blogger', 'location' => 'Chicago'],
                    ['text' => "The rating system and feedback from other cooks helped me refine my dishes. I've learned more in 3 months on Cuisto than in years of cooking alone.", 'author' => 'Aiko Tanaka', 'role' => 'Amateur Chef', 'location' => 'Tokyo'],
                ];
            @endphp
            @foreach($testimonials as $t)
            <div class="bg-white rounded-2xl p-8 border border-warm-200/60 relative">
                <i data-lucide="quote" class="w-8 h-8 text-brand-200 absolute top-6 right-6"></i>
                <p class="text-warm-600 leading-relaxed mb-6 text-sm">"{{ $t['text'] }}"</p>
                <div class="flex items-center gap-3 pt-4 border-t border-warm-100">
                    <div class="w-10 h-10 rounded-full bg-brand-100 flex items-center justify-center font-serif text-sm font-bold text-brand-600">
                        {{ implode('', array_map(function($w) { return strtoupper(substr($w,0,1)); }, explode(' ', $t['author']))) }}
                    </div>
                    <div>
                        <div class="font-semibold text-sm">{{ $t['author'] }}</div>
                        <div class="text-warm-500 text-xs">{{ $t['role'] }} · {{ $t['location'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endguest

    {{-- Stats Banner --}}
    @guest
    <section class="max-w-7xl mx-auto px-6 lg:px-8 pt-16 pb-8">
        <div class="bg-brand-500 rounded-3xl p-8 lg:p-12 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/3"></div>
            <div class="relative z-10">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="font-serif text-4xl lg:text-5xl font-semibold">50K+</div>
                        <div class="text-white/70 text-sm mt-2 uppercase tracking-wider">Recipes shared</div>
                    </div>
                    <div>
                        <div class="font-serif text-4xl lg:text-5xl font-semibold">120K+</div>
                        <div class="text-white/70 text-sm mt-2 uppercase tracking-wider">Active cooks</div>
                    </div>
                    <div>
                        <div class="font-serif text-4xl lg:text-5xl font-semibold">2M+</div>
                        <div class="text-white/70 text-sm mt-2 uppercase tracking-wider">Monthly views</div>
                    </div>
                    <div>
                        <div class="font-serif text-4xl lg:text-5xl font-semibold">4.9</div>
                        <div class="text-white/70 text-sm mt-2 uppercase tracking-wider">Average rating</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endguest

    {{-- User Welcome --}}
    @auth
    @if(Auth::user()->role !== 'admin')
    <section class="max-w-7xl mx-auto px-6 lg:px-8 pt-8">
        <div class="bg-white rounded-2xl p-6 lg:p-8 border border-warm-200/60 shadow-sm flex flex-col md:flex-row items-center gap-6">
            <div class="w-16 h-16 rounded-full bg-brand-100 border-2 border-brand-500 flex items-center justify-center flex-shrink-0">
                <span class="font-serif text-2xl font-semibold text-brand-600">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
            </div>
            <div class="flex-1 text-center md:text-left">
                <h3 class="font-serif text-xl font-semibold">Welcome back, {{ Auth::user()->name }}</h3>
                <p class="text-warm-500 text-sm mt-1">Ready to cook something new?</p>
                <div class="flex gap-6 mt-4 pt-4 border-t border-warm-100 justify-center md:justify-start">
                    <div>
                        <div class="font-serif text-2xl font-semibold text-brand-500">{{ $userStats['my_recipes_count'] ?? 0 }}</div>
                        <div class="text-xs text-warm-500 uppercase tracking-wider">Mes recettes</div>
                    </div>
                    <div>
                        <div class="font-serif text-2xl font-semibold text-brand-500">{{ $userStats['my_favorites_count'] ?? 0 }}</div>
                        <div class="text-xs text-warm-500 uppercase tracking-wider">Favoris</div>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 flex-shrink-0">
                <a href="{{ route('recipes.create') }}" class="btn-shine bg-brand-500 hover:bg-brand-600 text-white font-medium px-5 py-2.5 rounded-full transition-colors inline-flex items-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Nouvelle recette
                </a>
                <a href="{{ route('recipes.my') }}" class="bg-warm-50 hover:bg-warm-100 text-warm-700 border border-warm-200 font-medium px-5 py-2.5 rounded-full transition-colors">
                    Mes recettes
                </a>
            </div>
        </div>
    </section>
    @endif
    @endauth

    {{-- Categories --}}
    @if($categories->isNotEmpty())
    <section class="max-w-7xl mx-auto px-6 lg:px-8 pt-12">
        <div class="flex items-baseline justify-between mb-6 pb-4 border-b border-warm-200">
            <h2 class="font-serif text-2xl font-semibold">Parcourir by category</h2>
        </div>
        <div class="flex flex-wrap gap-3">
            @foreach($categories as $cat)
            <a href="{{ route('recipes.by-category', $cat->id) }}"
               class="chip-hover bg-white hover:bg-brand-500 text-warm-700 hover:text-white border border-warm-200 hover:border-brand-500 rounded-full px-5 py-2.5 text-sm font-medium transition-all inline-flex items-center gap-2">
                {{ $cat->name }}
                <span class="bg-warm-100 hover:bg-white/20 text-warm-500 hover:text-white/80 text-xs px-2 py-0.5 rounded-full transition-colors">{{ $cat->recipes_count }}</span>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Popular Recipes --}}
    @if($popularRecipes->isNotEmpty())
    <section class="max-w-7xl mx-auto px-6 lg:px-8 pt-12">
        <div class="flex items-baseline justify-between mb-6 pb-4 border-b border-warm-200">
            <h2 class="font-serif text-2xl font-semibold">Most popular</h2>
            <a href="{{ route('recipes.index') }}" class="text-brand-500 hover:text-brand-600 text-sm font-medium inline-flex items-center gap-1 transition-colors">
                View all
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($popularRecipes as $recipe)
            <a href="{{ route('recipes.show', $recipe) }}" class="card-hover bg-white rounded-2xl overflow-hidden border border-warm-200/60 group">
                <div class="aspect-[16/10] bg-gradient-to-br from-warm-200 to-warm-300 relative overflow-hidden">
                    @if($recipe->image)
                        <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover image-zoom">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i data-lucide="utensils" class="w-12 h-12 text-warm-400"></i>
                        </div>
                    @endif
                    @if($recipe->category)
                        <span class="absolute top-3 left-3 bg-brand-500 text-white text-xs font-semibold uppercase tracking-wider px-3 py-1.5 rounded-full">{{ $recipe->category->name }}</span>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-warm-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
                <div class="p-4">
                    <h3 class="font-serif text-lg font-semibold leading-tight group-hover:text-brand-500 transition-colors">{{ $recipe->title }}</h3>
                    <div class="flex items-center gap-4 mt-3 pt-3 border-t border-warm-100 text-sm text-warm-500">
                        @if($recipe->average_rating)
                            <span class="flex items-center gap-1">
                                <i data-lucide="star" class="w-3.5 h-3.5 text-gold-500 fill-gold-500"></i>
                                <span class="font-medium">{{ number_format($recipe->average_rating, 1) }}</span>
                            </span>
                        @endif
                        @if($recipe->cook_time)
                            <span class="flex items-center gap-1">
                                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                {{ $recipe->cook_time }} min
                            </span>
                        @endif
                        @if($recipe->servings)
                            <span class="flex items-center gap-1">
                                <i data-lucide="users" class="w-3.5 h-3.5"></i>
                                {{ $recipe->servings }}
                            </span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Recent Recipes --}}
    @if($recentRecipes->isNotEmpty())
    <section class="max-w-7xl mx-auto px-6 lg:px-8 pt-12">
        <div class="flex items-baseline justify-between mb-6 pb-4 border-b border-warm-200">
            <h2 class="font-serif text-2xl font-semibold">Just added</h2>
            <a href="{{ route('recipes.index') }}" class="text-brand-500 hover:text-brand-600 text-sm font-medium inline-flex items-center gap-1 transition-colors">
                View all
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($recentRecipes as $recipe)
            <a href="{{ route('recipes.show', $recipe) }}" class="card-hover bg-white rounded-2xl overflow-hidden border border-warm-200/60 group">
                <div class="aspect-[16/10] bg-gradient-to-br from-warm-200 to-warm-300 relative overflow-hidden">
                    @if($recipe->image)
                        <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover image-zoom">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i data-lucide="soup" class="w-12 h-12 text-warm-400"></i>
                        </div>
                    @endif
                    @if($recipe->category)
                        <span class="absolute top-3 left-3 bg-brand-500 text-white text-xs font-semibold uppercase tracking-wider px-3 py-1.5 rounded-full">{{ $recipe->category->name }}</span>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-serif text-lg font-semibold leading-tight group-hover:text-brand-500 transition-colors">{{ $recipe->title }}</h3>
                    <div class="flex items-center gap-4 mt-3 pt-3 border-t border-warm-100 text-sm text-warm-500">
                        @if($recipe->average_rating)
                            <span class="flex items-center gap-1">
                                <i data-lucide="star" class="w-3.5 h-3.5 text-gold-500 fill-gold-500"></i>
                                {{ number_format($recipe->average_rating, 1) }}
                            </span>
                        @endif
                        @if($recipe->cook_time)
                            <span class="flex items-center gap-1">
                                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                {{ $recipe->cook_time }} min
                            </span>
                        @endif
                        <span class="flex items-center gap-1">
                            <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                            {{ $recipe->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- User Favoris --}}
    @auth
    @php $userFavoris = $userFavoris ?? collect(); @endphp
    @if(Auth::user()->role !== 'admin' && $userFavoris->isNotEmpty())
    <section class="max-w-7xl mx-auto px-6 lg:px-8 pt-12">
        <div class="flex items-baseline justify-between mb-6 pb-4 border-b border-warm-200">
            <h2 class="font-serif text-2xl font-semibold">Your favorites</h2>
            <a href="{{ route('recipes.favorites') }}" class="text-brand-500 hover:text-brand-600 text-sm font-medium inline-flex items-center gap-1 transition-colors">
                See all
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($userFavoris as $recipe)
            <a href="{{ route('recipes.show', $recipe) }}" class="card-hover bg-white rounded-2xl overflow-hidden border border-warm-200/60 group">
                <div class="aspect-[16/10] bg-gradient-to-br from-warm-200 to-warm-300 relative overflow-hidden">
                    @if($recipe->image)
                        <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover image-zoom">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i data-lucide="heart" class="w-12 h-12 text-warm-400"></i>
                        </div>
                    @endif
                    @if($recipe->category)
                        <span class="absolute top-3 left-3 bg-brand-500 text-white text-xs font-semibold uppercase tracking-wider px-3 py-1.5 rounded-full">{{ $recipe->category->name }}</span>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-serif text-lg font-semibold leading-tight group-hover:text-brand-500 transition-colors">{{ $recipe->title }}</h3>
                    <div class="flex items-center gap-4 mt-3 pt-3 border-t border-warm-100 text-sm text-warm-500">
                        @if($recipe->cook_time)
                            <span class="flex items-center gap-1">
                                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                {{ $recipe->cook_time }} min
                            </span>
                        @endif
                        @if($recipe->servings)
                            <span class="flex items-center gap-1">
                                <i data-lucide="users" class="w-3.5 h-3.5"></i>
                                {{ $recipe->servings }}
                            </span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif
    @endauth

    {{-- Tag Cloud --}}
    @if($tags->isNotEmpty())
    <section class="max-w-7xl mx-auto px-6 lg:px-8 pt-12 pb-4">
        <div class="flex items-baseline justify-between mb-6 pb-4 border-b border-warm-200">
            <h2 class="font-serif text-2xl font-semibold">Explore tags</h2>
        </div>
        <div class="flex flex-wrap gap-2">
            @foreach($tags as $tag)
            <a href="{{ route('recipes.by-tag', $tag->id) }}"
               class="bg-white hover:bg-gold-500 text-warm-600 hover:text-warm-900 border border-warm-200 hover:border-gold-500 rounded-full px-4 py-2 text-sm font-medium transition-all">
                #{{ $tag->name }}
                <span class="text-warm-400 text-xs ml-1">({{ $tag->recipes_count }})</span>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Final CTA --}}
    @guest
    <section class="max-w-7xl mx-auto px-6 lg:px-8 pt-16 pb-16">
        <div class="bg-warm-900 rounded-3xl p-10 lg:p-16 text-center text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-brand-500/10 rounded-full -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-gold-500/10 rounded-full translate-y-1/2 -translate-x-1/3"></div>
            <div class="relative z-10 max-w-2xl mx-auto">
                <div class="inline-flex items-center gap-2 bg-white/10 text-white/80 text-xs font-semibold uppercase tracking-widest px-4 py-2 rounded-full mb-6">
                    <i data-lucide="zap" class="w-3.5 h-3.5"></i>
                    Join in 30 seconds
                </div>
                <h2 class="font-serif text-3xl lg:text-5xl font-semibold mb-4">Start your cooking journey today</h2>
                <p class="text-white/60 text-lg mb-8 leading-relaxed max-w-lg mx-auto">Join a community of passionate cooks, share your creations, discover new flavors, and build your culinary reputation. No fees, no limits — just great food.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('signup') }}" class="btn-shine bg-brand-500 hover:bg-brand-600 text-white font-semibold px-8 py-4 rounded-full transition-colors inline-flex items-center gap-2">
                        Get started free
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </a>
                    <a href="{{ route('recipes.index') }}" class="bg-white/10 hover:bg-white/20 text-white font-medium px-8 py-4 rounded-full transition-colors inline-flex items-center gap-2">
                        <i data-lucide="search" class="w-5 h-5"></i>
                        Explore recipes
                    </a>
                </div>
                <p class="text-white/40 text-sm mt-6">Trusted by 120,000+ cooks worldwide · No credit card required</p>
            </div>
        </div>
    </section>
    @endguest

    {{-- Footer --}}
    <footer class="border-t border-warm-200 mt-16">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
            <p class="text-center text-warm-500 text-sm">
                © {{ date('Y') }} <a href="{{ route('home') }}" class="text-brand-500 hover:text-brand-600 font-medium">Cuisto</a> — made with
                <i data-lucide="heart" class="w-3.5 h-3.5 inline text-brand-500 fill-brand-500"></i>
                for home cooks everywhere.
            </p>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
