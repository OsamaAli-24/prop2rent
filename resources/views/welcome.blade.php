<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Building Management System</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>
        
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    </head>
    <body class="h-screen flex flex-col justify-between items-center relative overflow-hidden">

        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop" 
                 class="w-full h-full object-cover" 
                 alt="Building Background">
            
            <div class="absolute inset-0 bg-black/40"></div>
        </div>

        <div class="relative z-10"></div>

        <div class="relative z-10 w-full max-w-lg px-6">
            <div class="bg-white/95 backdrop-blur-sm p-10 rounded-2xl shadow-2xl border border-white/50">
                
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-14 h-14 bg-black text-white rounded-lg mb-4 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h1 class="text-4xl font-extrabold text-black tracking-tight uppercase">BMS Portal</h1>
                    <p class="text-gray-600 mt-2 font-medium">Building Management System</p>
                </div>

                <hr class="border-gray-300 mb-8">

                @if (Route::has('login'))
                    <div class="flex flex-row justify-between items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="w-full text-center py-3 bg-black text-white font-bold rounded-lg hover:bg-gray-800 transition shadow-lg">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="w-1/2 text-center py-3 px-4 bg-black text-white font-bold rounded-lg hover:bg-gray-800 transition shadow-lg transform hover:-translate-y-0.5">
                                Login
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" 
                                   class="w-1/2 text-center py-3 px-4 bg-white border-2 border-black text-black font-bold rounded-lg hover:bg-black hover:text-white transition shadow-lg transform hover:-translate-y-0.5">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif

            </div>
        </div>

        <div class="relative z-10 pb-8 text-center">
            <p class="text-sm font-bold text-white tracking-widest uppercase drop-shadow-md">
                &copy; 2025 Building Management System
            </p>
        </div>

    </body>
</html>