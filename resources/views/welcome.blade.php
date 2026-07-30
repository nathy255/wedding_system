<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENTA | Every Event. One Platform.</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --bg-dark: #0A0A10;
            --brand-purple: #8B5CF6;
            --brand-magenta: #D946EF;
            --brand-coral: #F43F5E;
            --brand-peach: #FB923C;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: #fff;
            overflow-x: hidden;
        }

        /* ─── Premium Utilities ─────────────────────────────── */
        .glass-nav {
            background: rgba(10, 10, 16, 0.7);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            box-shadow: 0 24px 64px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.1);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s;
        }
        .glass-card:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 32px 80px rgba(139, 92, 246, 0.15), inset 0 1px 0 rgba(255,255,255,0.15);
            border-color: rgba(255, 255, 255, 0.12);
        }

        .text-gradient {
            background: linear-gradient(135deg, #fff 0%, rgba(255,255,255,0.6) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .text-brand-gradient {
            background: linear-gradient(135deg, var(--brand-purple), var(--brand-magenta), var(--brand-coral));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-premium {
            background: linear-gradient(135deg, var(--brand-purple), var(--brand-magenta));
            color: #fff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(139, 92, 246, 0.3);
            transition: all 0.3s ease;
            z-index: 1;
        }
        .btn-premium::before {
            content: '';
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, var(--brand-magenta), var(--brand-coral));
            opacity: 0;
            z-index: -1;
            transition: opacity 0.3s ease;
        }
        .btn-premium:hover { transform: translateY(-2px); box-shadow: 0 16px 48px rgba(139, 92, 246, 0.5); }
        .btn-premium:hover::before { opacity: 1; }

        /* ─── Hero Animations ───────────────────────────────── */
        .hero-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.5;
            z-index: -1;
            animation: floatBlob 20s infinite alternate;
        }
        @keyframes floatBlob {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(100px, 50px) scale(1.2); }
            100% { transform: translate(-50px, 100px) scale(0.9); }
        }

        .grid-pattern {
            position: absolute; inset: 0;
            background-image: 
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse at center, black 0%, transparent 80%);
            -webkit-mask-image: radial-gradient(ellipse at center, black 0%, transparent 80%);
            pointer-events: none;
            z-index: -1;
        }

        .fade-in-up {
            animation: fadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0; transform: translateY(40px);
        }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }

        /* ─── Search Bar ────────────────────────────────────── */
        .premium-search {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(20px);
            border-radius: 99px;
            padding: 8px 8px 8px 24px;
            display: flex; align-items: center; gap: 16px;
            box-shadow: 0 32px 64px rgba(0,0,0,0.5);
            transition: all 0.3s ease;
        }
        .premium-search:focus-within {
            border-color: rgba(139, 92, 246, 0.5);
            background: rgba(255,255,255,0.08);
            box-shadow: 0 32px 80px rgba(139, 92, 246, 0.2);
        }
        .premium-search input {
            background: transparent; border: none; outline: none; color: #fff; width: 100%; font-size: 16px;
        }
        .premium-search input::placeholder { color: rgba(255,255,255,0.4); }

        /* ─── Bento Grid ────────────────────────────────────── */
        .bento-container {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 24px;
        }
        .bento-item { border-radius: 32px; overflow: hidden; position: relative; }
        .bento-large { grid-column: span 8; }
        .bento-small { grid-column: span 4; }
        
        @media(max-width: 1024px) {
            .bento-large, .bento-small { grid-column: span 12; }
        }
    </style>
</head>
<body class="antialiased selection:bg-purple-500 selection:text-white">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass-nav">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                    <i class="fa-solid fa-gem text-white text-xs"></i>
                </div>
                <span class="text-xl font-bold tracking-tight">EVENTA</span>
            </div>
            
            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-300">
                <a href="#features" class="hover:text-white transition">Features</a>
                <a href="#vendors" class="hover:text-white transition">Marketplace</a>
                <a href="#pricing" class="hover:text-white transition">Pricing</a>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-white transition">Sign In</a>
                <a href="{{ route('register') }}" class="btn-premium px-6 py-2.5 rounded-full text-sm font-semibold">
                    Get Started
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-48 pb-32 overflow-hidden flex flex-col items-center justify-center min-h-screen text-center px-4">
        <!-- Blobs & Grid -->
        <div class="hero-blob w-[800px] h-[800px] bg-purple-600 top-[-20%] left-[-10%]"></div>
        <div class="hero-blob w-[600px] h-[600px] bg-pink-600 bottom-[-10%] right-[-10%]" style="animation-delay:-5s;"></div>
        <div class="hero-blob w-[500px] h-[500px] bg-orange-500 top-[20%] right-[20%] opacity-30" style="animation-delay:-10s;"></div>
        <div class="grid-pattern"></div>

        <div class="max-w-4xl relative z-10 mx-auto">
            <div class="fade-in-up inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/10 bg-white/5 backdrop-blur-md mb-8">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                <span class="text-xs font-semibold text-gray-300 tracking-wide uppercase">Introducing EVENTA OS 2.0</span>
            </div>
            
            <h1 class="fade-in-up text-6xl md:text-8xl font-extrabold tracking-tighter leading-[1.05] mb-8" style="animation-delay: 0.1s;">
                Every Event. <br>
                <span class="text-brand-gradient">One Platform.</span>
            </h1>
            
            <p class="fade-in-up text-lg md:text-xl text-gray-400 font-light max-w-2xl mx-auto leading-relaxed mb-12" style="animation-delay: 0.2s;">
                Plan smarter. Celebrate better. The world's most luxurious operating platform for weddings, conferences, fundraisers, and corporate events.
            </p>

            <div class="fade-in-up max-w-2xl mx-auto" style="animation-delay: 0.3s;">
                <div class="premium-search w-full max-w-xl mx-auto">
                    <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                    <input type="text" placeholder="What are you planning? (e.g. Wedding in Dubai)">
                    <button class="bg-white text-black px-6 py-3 rounded-full text-sm font-semibold hover:bg-gray-100 transition shadow-lg shrink-0">
                        Start Building
                    </button>
                </div>
            </div>
        </div>

        <!-- Dashboard Preview Float -->
        <div class="w-full max-w-6xl mx-auto mt-24 relative z-10 fade-in-up" style="animation-delay: 0.5s;">
            <div class="glass-card p-2 rounded-[32px] transform perspective-1000 rotate-x-12 scale-100 md:scale-105 transition duration-700 hover:rotate-x-0">
                <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=2500&auto=format&fit=crop" alt="Eventa Dashboard" class="w-full h-auto rounded-[24px] object-cover opacity-80" style="height: 600px; filter: saturate(1.2) contrast(1.1);">
                <!-- Overlay Gradient for UI simulation -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent rounded-[32px]"></div>
                
                <!-- Floating UI Elements -->
                <div class="absolute bottom-12 left-12 glass-card p-6 rounded-2xl w-80">
                    <div class="text-xs text-gray-400 uppercase tracking-widest mb-1">Total Budget</div>
                    <div class="text-3xl font-bold text-white mb-4">$45,000</div>
                    <div class="w-full h-2 bg-white/10 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-purple-500 to-pink-500 w-[68%]"></div>
                    </div>
                </div>

                <div class="absolute top-12 right-12 glass-card p-4 rounded-full flex items-center gap-4 pr-6">
                    <img src="https://ui-avatars.com/api/?name=Sarah+J&background=10B981&color=fff" class="w-10 h-10 rounded-full">
                    <div>
                        <div class="text-sm font-bold text-white">Guest RSVP</div>
                        <div class="text-xs text-green-400">Just confirmed!</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Logo Cloud -->
    <section class="py-12 border-y border-white/5 bg-white/5">
        <div class="max-w-7xl mx-auto px-6">
            <p class="text-center text-sm font-medium text-gray-500 uppercase tracking-widest mb-8">Trusted by world-class planners & vendors</p>
            <div class="flex flex-wrap justify-center items-center gap-12 md:gap-24 opacity-40 grayscale hover:grayscale-0 transition-all duration-500">
                <i class="fa-brands fa-apple text-3xl hover:text-white transition"></i>
                <i class="fa-brands fa-airbnb text-3xl hover:text-[#FF5A5F] transition"></i>
                <i class="fa-brands fa-stripe text-3xl hover:text-[#635BFF] transition"></i>
                <i class="fa-brands fa-slack text-3xl hover:text-[#E01E5A] transition"></i>
                <i class="fa-brands fa-figma text-3xl hover:text-[#F24E1E] transition"></i>
            </div>
        </div>
    </section>

    <!-- Features Bento Grid -->
    <section id="features" class="py-32 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-20">
                <h2 class="text-4xl md:text-6xl font-bold tracking-tight mb-6">Designed like magic.<br>Engineered like a bank.</h2>
                <p class="text-xl text-gray-400 font-light max-w-2xl">Stop juggling spreadsheets, WhatsApp groups, and bank apps. EVENTA unites every tool into one luxurious workspace.</p>
            </div>

            <div class="bento-container">
                <!-- Large Item 1 -->
                <div class="bento-item bento-large glass-card p-12 min-h-[400px] flex flex-col justify-between group cursor-pointer">
                    <div class="relative z-10">
                        <i class="fa-solid fa-wand-magic-sparkles text-4xl text-brand-magenta mb-6"></i>
                        <h3 class="text-3xl font-bold mb-4">AI Event Copilot</h3>
                        <p class="text-gray-400 text-lg max-w-md">Let our AI generate your budget, build timelines, recommend verified vendors, and draft your invitations instantly.</p>
                    </div>
                    <!-- Decorative Background element -->
                    <div class="absolute right-0 bottom-0 w-2/3 h-2/3 bg-gradient-to-tl from-purple-500/20 to-transparent rounded-tl-[100px] opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>

                <!-- Small Item 1 -->
                <div class="bento-item bento-small glass-card p-12 min-h-[400px] flex flex-col justify-between">
                    <div>
                        <i class="fa-solid fa-money-bill-transfer text-4xl text-green-400 mb-6"></i>
                        <h3 class="text-2xl font-bold mb-4">M-Pesa & Card Ready</h3>
                        <p class="text-gray-400">Collect contributions and sell tickets globally with built-in escrow.</p>
                    </div>
                </div>

                <!-- Small Item 2 -->
                <div class="bento-item bento-small glass-card p-12 min-h-[400px] flex flex-col justify-between" style="background: linear-gradient(135deg, #1A1A24 0%, #0F0F16 100%);">
                    <div>
                        <i class="fa-solid fa-people-group text-4xl text-blue-400 mb-6"></i>
                        <h3 class="text-2xl font-bold mb-4">Smart RSVPs</h3>
                        <p class="text-gray-400">Dynamic seating charts and NFC check-ins at the door.</p>
                    </div>
                </div>

                <!-- Large Item 2 -->
                <div class="bento-item bento-large glass-card p-0 min-h-[400px] relative overflow-hidden group">
                    <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?q=80&w=2500&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:opacity-60 transition duration-700 transform group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-12">
                        <h3 class="text-3xl font-bold mb-4 text-white">Vendor Marketplace</h3>
                        <p class="text-gray-300 text-lg max-w-md">Discover, negotiate, sign contracts, and pay top-tier photographers, caterers, and venues directly on-platform.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats / Trust -->
    <section class="py-32 bg-[#050508] border-y border-white/5">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-5xl font-bold mb-16">Africa's most beautiful event ecosystem.</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div>
                    <div class="text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600 mb-4">2.4M+</div>
                    <div class="text-gray-400 text-sm tracking-widest uppercase">Dollars Transacted</div>
                </div>
                <div>
                    <div class="text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-orange-500 mb-4">12,500</div>
                    <div class="text-gray-400 text-sm tracking-widest uppercase">Events Hosted</div>
                </div>
                <div>
                    <div class="text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-yellow-500 mb-4">99.9%</div>
                    <div class="text-gray-400 text-sm tracking-widest uppercase">Uptime Reliability</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-40 relative overflow-hidden flex justify-center text-center">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-purple-900/20 z-0"></div>
        <div class="relative z-10 max-w-3xl mx-auto px-6">
            <h2 class="text-5xl md:text-7xl font-bold tracking-tight mb-8">Ready to celebrate?</h2>
            <p class="text-xl text-gray-400 mb-12">Join thousands of planners and couples creating unforgettable moments on EVENTA.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="btn-premium px-8 py-4 rounded-full text-lg font-bold shadow-2xl w-full sm:w-auto">
                    Create Your Event
                </a>
                <a href="#" class="px-8 py-4 rounded-full text-lg font-bold text-white bg-white/5 border border-white/10 hover:bg-white/10 transition w-full sm:w-auto">
                    List as a Vendor
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black py-16 border-t border-white/10 text-sm">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            <div>
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                        <i class="fa-solid fa-gem text-white text-[10px]"></i>
                    </div>
                    <span class="font-bold tracking-tight text-white">EVENTA</span>
                </div>
                <p class="text-gray-500 leading-relaxed mb-6">Built by SPACITEK. The operating platform for every event, bringing order and beauty to the chaos of planning.</p>
                <div class="flex gap-4 text-gray-400">
                    <a href="#" class="hover:text-white transition"><i class="fa-brands fa-twitter text-lg"></i></a>
                    <a href="#" class="hover:text-white transition"><i class="fa-brands fa-instagram text-lg"></i></a>
                    <a href="#" class="hover:text-white transition"><i class="fa-brands fa-linkedin text-lg"></i></a>
                </div>
            </div>
            
            <div>
                <h4 class="text-white font-semibold mb-6 uppercase tracking-wider text-xs">Product</h4>
                <ul class="space-y-4 text-gray-400">
                    <li><a href="#" class="hover:text-white transition">AI Event Planner</a></li>
                    <li><a href="#" class="hover:text-white transition">Vendor Marketplace</a></li>
                    <li><a href="#" class="hover:text-white transition">Ticketing & RSVPs</a></li>
                    <li><a href="#" class="hover:text-white transition">Payment Collection</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-6 uppercase tracking-wider text-xs">Resources</h4>
                <ul class="space-y-4 text-gray-400">
                    <li><a href="#" class="hover:text-white transition">Inspiration Gallery</a></li>
                    <li><a href="#" class="hover:text-white transition">Help Center</a></li>
                    <li><a href="#" class="hover:text-white transition">Vendor Guidelines</a></li>
                    <li><a href="#" class="hover:text-white transition">Blog</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-6 uppercase tracking-wider text-xs">Company</h4>
                <ul class="space-y-4 text-gray-400">
                    <li><a href="#" class="hover:text-white transition">About SPACITEK</a></li>
                    <li><a href="#" class="hover:text-white transition">Careers</a></li>
                    <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                </ul>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto px-6 border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-gray-600">© 2026 EVENTA by SPACITEK. All rights reserved.</div>
            <div class="flex items-center gap-2 text-gray-600">
                <i class="fa-solid fa-globe"></i> English (US) · TZS (Tanzania)
            </div>
        </div>
    </footer>

</body>
</html>
