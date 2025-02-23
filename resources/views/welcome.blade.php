<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Voucha - Customer Loyalty Made Simple</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
        <!-- Add GSAP -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    </head>
    <body class="antialiased bg-gradient-to-b from-gray-50 to-white">
        <!-- Navigation -->
        <nav class="bg-white/80 backdrop-blur-md fixed w-full z-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <img src="{{ asset('images/voucher-logo.png') }}" alt="Voucha Logo" class="h-12 ml-2">
                    </div>
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#features" class="text-gray-600 hover:text-indigo-600 transition duration-300">Features</a>
                        <a href="#how-it-works" class="text-gray-600 hover:text-indigo-600 transition duration-300">How it Works</a>
                        <a href="#pricing" class="text-gray-600 hover:text-indigo-600 transition duration-300">Pricing</a>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-indigo-600 font-semibold hover:text-indigo-700 transition duration-300">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 transition duration-300">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-full font-medium hover:shadow-lg hover:scale-105 transition duration-300">Get Started</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="hero-section relative overflow-hidden bg-gradient-to-b from-white to-gray-50 pt-32 pb-20 lg:pt-40 lg:pb-28">
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-[radial-gradient(45rem_50rem_at_top,theme(colors.indigo.100),white)] opacity-20"></div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                    <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left"
                         x-data="{ show: true }"
                         x-init="setTimeout(() => show = true, 100)">
                        <div class="space-y-5"
                             :class="{ 'opacity-100 translate-y-0': show, 'opacity-0 translate-y-10': !show }"
                             style="transition: all 1s ease-out">
                            <div class="inline-flex items-center space-x-2 px-4 py-2 bg-gray-100 rounded-full">
                                <span class="flex h-2 w-2 rounded-full bg-indigo-600"></span>
                                <span class="text-sm font-medium text-gray-600">Seamless Integration with Your Brand</span>
                            </div>
                            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                                <span class="block">Transform Your</span>
                                <span class="block bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">Customer Loyalty</span>
                            </h1>
                            <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">
                                Build lasting customer relationships with Voucha's comprehensive loyalty platform. From tiered rewards to targeted campaigns, we help you create a loyalty program that drives engagement and growth.
                            </p>
                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-3 sm:space-y-0">
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-medium rounded-full text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:shadow-lg hover:scale-105 transition duration-300">
                                    Start Free Trial
                                </a>
                                <a href="#demo" class="inline-flex items-center justify-center px-8 py-4 border-2 border-gray-200 text-base font-medium rounded-full text-gray-600 hover:border-indigo-600 hover:text-indigo-600 transition duration-300">
                                    Watch Demo
                                </a>
                            </div>
                            <div class="mt-6 flex items-center space-x-6">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm text-gray-500">Free 14-day trial</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm text-gray-500">No credit card required</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
                        <div class="relative mx-auto w-full rounded-2xl shadow-xl lg:max-w-md overflow-hidden transform hover:scale-105 transition duration-500"
                             x-data="{ show: true }"
                             x-init="setTimeout(() => show = true, 200)"
                             :class="{ 'opacity-100 translate-x-0': show, 'opacity-0 translate-x-10': !show }"
                             style="transition: all 1s ease-out">
                            <div class="relative bg-white rounded-2xl overflow-hidden">
                                <img class="w-full" src="https://placehold.co/600x400/667EEA/FFFFFF/png?text=Voucha+Demo&font=Montserrat" alt="App screenshot">
                                <div class="absolute inset-0 bg-gradient-to-tr from-indigo-600/20 to-purple-600/20"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div id="features" class="features-section py-24 bg-white opacity-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl lg:text-5xl">
                        Comprehensive Loyalty Management
                    </h2>
                    <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                        Everything you need to create, manage, and grow your loyalty program
                    </p>
                </div>

                <div class="mt-20 grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1: Tiered Loyalty System -->
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl opacity-25 group-hover:opacity-100 transition duration-500 blur"></div>
                        <div class="relative bg-white rounded-2xl p-8 transition duration-500 hover:shadow-xl">
                            <div class="w-14 h-14 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                            </div>
                            <h3 class="mt-6 text-xl font-semibold text-gray-900">Tiered Rewards Program</h3>
                            <p class="mt-4 text-gray-500 leading-relaxed">Create engaging loyalty tiers (Bronze, Silver, Gold) with custom benefits and point requirements. Motivate customers to reach higher tiers for better rewards.</p>
                        </div>
                    </div>

                    <!-- Feature 2: Flexible Points System -->
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl opacity-25 group-hover:opacity-100 transition duration-500 blur"></div>
                        <div class="relative bg-white rounded-2xl p-8 transition duration-500 hover:shadow-xl">
                            <div class="w-14 h-14 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="mt-6 text-xl font-semibold text-gray-900">Dynamic Points Engine</h3>
                            <p class="mt-4 text-gray-500 leading-relaxed">Award points for transactions, referrals, and more. Support for multiple point types, expiry rules, and automatic point calculations based on transaction type.</p>
                        </div>
                    </div>

                    <!-- Feature 3: Campaign Management -->
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl opacity-25 group-hover:opacity-100 transition duration-500 blur"></div>
                        <div class="relative bg-white rounded-2xl p-8 transition duration-500 hover:shadow-xl">
                            <div class="w-14 h-14 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                                </svg>
                            </div>
                            <h3 class="mt-6 text-xl font-semibold text-gray-900">Smart Campaigns</h3>
                            <p class="mt-4 text-gray-500 leading-relaxed">Create targeted campaigns with point multipliers for specific transaction types or user segments. Time-limited promotions to drive engagement.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Use Cases Section -->
        <div id="use-cases" class="use-cases-section py-24 bg-gray-50 opacity-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl lg:text-5xl">
                        Use Cases: Who Benefits from Voucha?
                    </h2>
                    <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                        Voucha is versatile and powerful, ideal for a wide range of businesses.
                    </p>
                </div>

                <div class="mt-20 grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Use Case 1: Retail -->
                    <div class="bg-white rounded-2xl p-8 transition duration-500 hover:shadow-xl">
                        <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v2.581m0 3.198v2.581m0 3.198v2.581m0 3.198V21M3 6.781h18M3 12.98h18M3 19.18h18M5.914 3h.01m5.076 0h.01m5.076 0h.01"></path>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900">Retail Stores</h3>
                        <p class="mt-4 text-gray-500 leading-relaxed">Boost repeat purchases and customer lifetime value. Reward frequent shoppers with points for every purchase, leading to discounts, exclusive offers, and tiered benefits.</p>
                    </div>

                    <!-- Use Case 2: Service Industry -->
                    <div class="bg-white rounded-2xl p-8 transition duration-500 hover:shadow-xl">
                        <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900">Service Providers</h3>
                        <p class="mt-4 text-gray-500 leading-relaxed">Increase customer frequency and loyalty in services like salons, spas, and auto services. Reward customers for regular appointments and referrals, fostering long-term relationships.</p>
                    </div>

                    <!-- Use Case 3: Online Businesses -->
                    <div class="bg-white rounded-2xl p-8 transition duration-500 hover:shadow-xl">
                        <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 00-9 9m-9-9a9 9 0 009-9m-3 3v12m-3-3h12m-9-3V3m3 3h12m-9 3v12m-3-3h12"></path>
                            </svg>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900">E-commerce & Online Platforms</h3>
                        <p class="mt-4 text-gray-500 leading-relaxed">Drive customer retention and increase online sales. Reward points for purchases, reviews, and social sharing, encouraging repeat business and brand advocacy.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- How It Works Section -->
        <div id="how-it-works" class="how-it-works-section py-24 bg-white opacity-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl lg:text-5xl">
                        How Voucha Works
                    </h2>
                    <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                        Simple steps to launch your customer loyalty program.
                    </p>
                </div>

                <div class="mt-20 grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Step 1: Setup -->
                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 bg-indigo-100 rounded-full flex items-center justify-center">
                            <span class="text-3xl font-bold text-indigo-700">1</span>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900">Setup Your Program</h3>
                        <p class="mt-4 text-gray-500 text-center leading-relaxed">Define your loyalty tiers, points system, and rewards. Integrate Voucha with your existing systems using our brand user ID.</p>
                    </div>

                    <!-- Step 2: Engage -->
                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 bg-indigo-100 rounded-full flex items-center justify-center">
                            <span class="text-3xl font-bold text-indigo-700">2</span>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900">Engage Customers</h3>
                        <p class="mt-4 text-gray-500 text-center leading-relaxed">Customers earn points through transactions and interactions. Promote your loyalty program to encourage sign-ups and participation.</p>
                    </div>

                    <!-- Step 3: Reward -->
                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 bg-indigo-100 rounded-full flex items-center justify-center">
                            <span class="text-3xl font-bold text-indigo-700">3</span>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold text-gray-900">Reward Loyalty</h3>
                        <p class="mt-4 text-gray-500 text-center leading-relaxed">Customers redeem points for rewards, discounts, and exclusive offers. Track performance and optimize your program with our analytics dashboard.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="stats-section bg-gradient-to-r from-indigo-600 to-purple-600 opacity-0">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8 lg:py-20">
                <div class="max-w-4xl mx-auto text-center">
                    <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                        Built for Scale and Performance
                    </h2>
                    <p class="mt-3 text-xl text-indigo-200">
                        Enterprise-ready loyalty management platform
                    </p>
                </div>
                <dl class="mt-10 text-center sm:max-w-3xl sm:mx-auto sm:grid sm:grid-cols-3 sm:gap-8">
                    <div class="flex flex-col">
                        <dt class="order-2 mt-2 text-lg leading-6 font-medium text-indigo-200">
                            Transaction Types
                        </dt>
                        <dd class="order-1 text-5xl font-extrabold text-white">
                            Multiple
                        </dd>
                    </div>
                    <div class="flex flex-col mt-10 sm:mt-0">
                        <dt class="order-2 mt-2 text-lg leading-6 font-medium text-indigo-200">
                            Integration
                        </dt>
                        <dd class="order-1 text-5xl font-extrabold text-white">
                            Seamless
                        </dd>
                    </div>
                    <div class="flex flex-col mt-10 sm:mt-0">
                        <dt class="order-2 mt-2 text-lg leading-6 font-medium text-indigo-200">
                            Reward Types
                        </dt>
                        <dd class="order-1 text-5xl font-extrabold text-white">
                            Flexible
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="cta-section relative bg-white opacity-0">
            <div class="absolute left-0 right-0 h-1/2 bg-gray-50"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto">
                    <div class="rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 shadow-xl">
                        <div class="px-6 py-12 sm:p-16">
                            <div class="text-center">
                                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                                    <span class="block">Ready to grow your business?</span>
                                    <span class="block">Start your free trial today.</span>
                                </h2>
                                <p class="mt-4 text-lg leading-6 text-indigo-100">
                                    No credit card required. Cancel anytime.
                                </p>
                                <a href="{{ route('register') }}" class="mt-8 w-full inline-flex items-center justify-center px-10 py-4 border border-transparent text-base font-medium rounded-full text-indigo-600 bg-white hover:bg-gray-50 hover:shadow-lg hover:scale-105 transition duration-300 sm:w-auto">
                                    Get started for free
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer-section bg-gray-50 opacity-0">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Product</h3>
                        <ul class="mt-4 space-y-4">
                            <li><a href="#" class="text-base text-gray-500 hover:text-indigo-600">Features</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-indigo-600">Pricing</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-indigo-600">API</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Company</h3>
                        <ul class="mt-4 space-y-4">
                            <li><a href="#" class="text-base text-gray-500 hover:text-indigo-600">About</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-indigo-600">Blog</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-indigo-600">Careers</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Resources</h3>
                        <ul class="mt-4 space-y-4">
                            <li><a href="#" class="text-base text-gray-500 hover:text-indigo-600">Documentation</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-indigo-600">Help Center</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-indigo-600">Guides</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Legal</h3>
                        <ul class="mt-4 space-y-4">
                            <li><a href="#" class="text-base text-gray-500 hover:text-indigo-600">Privacy</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-indigo-600">Terms</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-indigo-600">Security</a></li>
                        </ul>
                    </div>
                </div>
                <div class="mt-12 border-t border-gray-200 pt-8">
                    <p class="text-base text-gray-400 text-center">&copy; {{ date('Y') }} Voucha. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <!-- GSAP Animation Script -->
        <script>
            gsap.registerPlugin(ScrollTrigger);

            // Force scroll to top on page load
            window.onbeforeunload = function () {
                window.scrollTo(0, 0);
            };

            // Wait for page load before starting animations
            window.addEventListener('load', () => {
                // Ensure we're at the top
                window.scrollTo(0, 0);

                // Initial hero animation without y-transform
                gsap.from('.hero-section', {
                    duration: 1.2,
                    opacity: 0,
                    ease: 'power3.out',
                    delay: 0.5
                });

                // Animate hero content separately
                gsap.from('.hero-section .space-y-5 > *', {
                    duration: 1.2,
                    y: 40,
                    opacity: 0,
                    stagger: 0.2,
                    ease: 'power3.out',
                    delay: 0.7
                });

                // Animate sections on scroll
                const sections = [
                    '.features-section',
                    '.use-cases-section',
                    '.how-it-works-section',
                    '.stats-section',
                    '.cta-section',
                    '.footer-section'
                ];

                sections.forEach(section => {
                    gsap.to(section, {
                        scrollTrigger: {
                            trigger: section,
                            start: 'top 60%',
                            end: 'top 20%',
                            toggleActions: 'play none none reverse',
                            markers: false
                        },
                        duration: 1.2,
                        opacity: 1,
                        y: 0,
                        ease: 'power3.out'
                    });
                });

                // Animate feature cards individually with sequence
                const featureCards = gsap.utils.toArray('.features-section .relative.group');
                featureCards.forEach((card, index) => {
                    gsap.from(card, {
                        scrollTrigger: {
                            trigger: card,
                            start: 'top 70%',
                            toggleActions: 'play none none reverse',
                            markers: false
                        },
                        duration: 1,
                        y: 60,
                        opacity: 0,
                        ease: 'power3.out',
                        delay: index * 0.3
                    });
                });

                // Animate use cases with individual triggers
                const useCases = gsap.utils.toArray('.use-cases-section .bg-white');
                useCases.forEach((card, index) => {
                    gsap.from(card, {
                        scrollTrigger: {
                            trigger: card,
                            start: 'top 70%',
                            toggleActions: 'play none none reverse',
                        },
                        duration: 1,
                        y: 60,
                        opacity: 0,
                        ease: 'power3.out',
                        delay: index * 0.3
                    });
                });

                // Animate how it works steps with individual triggers
                const steps = gsap.utils.toArray('.how-it-works-section .flex-col');
                steps.forEach((step, index) => {
                    gsap.from(step, {
                        scrollTrigger: {
                            trigger: step,
                            start: 'top 70%',
                            toggleActions: 'play none none reverse',
                        },
                        duration: 1,
                        y: 60,
                        opacity: 0,
                        ease: 'power3.out',
                        delay: index * 0.3
                    });
                });

                // Animate stats with individual triggers
                const stats = gsap.utils.toArray('.stats-section .flex-col');
                stats.forEach((stat, index) => {
                    gsap.from(stat, {
                        scrollTrigger: {
                            trigger: stat,
                            start: 'top 70%',
                            toggleActions: 'play none none reverse',
                        },
                        duration: 1,
                        y: 40,
                        opacity: 0,
                        ease: 'power3.out',
                        delay: index * 0.3
                    });
                });

                // Special animation for CTA
                gsap.from('.cta-section .rounded-2xl', {
                    scrollTrigger: {
                        trigger: '.cta-section',
                        start: 'top 70%',
                        toggleActions: 'play none none reverse',
                    },
                    duration: 1.2,
                    scale: 0.9,
                    opacity: 0,
                    ease: 'power3.out'
                });

                // Footer links animation with individual triggers
                const footerColumns = gsap.utils.toArray('.footer-section .grid > div');
                footerColumns.forEach((column, index) => {
                    gsap.from(column, {
                        scrollTrigger: {
                            trigger: column,
                            start: 'top 80%',
                            toggleActions: 'play none none reverse',
                        },
                        duration: 1,
                        y: 40,
                        opacity: 0,
                        ease: 'power3.out',
                        delay: index * 0.2
                    });
                });
            });
        </script>
    </body>
</html>
