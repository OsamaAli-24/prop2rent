<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-900 to-indigo-900 flex items-center justify-center p-6">
        
        <div class="w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row h-auto md:h-[600px]">
            
            <div class="w-full md:w-1/2 bg-blue-900 relative flex flex-col justify-center text-white overflow-hidden">
                
                <div class="absolute inset-0 z-0">
                    <img src="https://images.unsplash.com/photo-1554469384-e58fac16e23a?q=80&w=1000&auto=format&fit=crop" 
                         alt="Building Background" 
                         class="w-full h-full object-cover opacity-40 mix-blend-overlay">
                    <div class="absolute inset-0 bg-blue-900/40"></div>
                </div>
                
                <div class="relative z-10 p-10 text-center md:text-left">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mb-8 mx-auto md:mx-0 shadow-inner border border-white/10">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    
                    <h1 class="text-4xl font-black tracking-tight mb-3 drop-shadow-lg">Building<br>Management</h1>
                    <p class="text-blue-100 text-lg font-light tracking-wide opacity-90 drop-shadow-md">Control • Monitor • Secure</p>
                    
                    <div class="w-12 h-1 bg-blue-400 rounded-full mt-8 mx-auto md:mx-0 shadow-lg"></div>
                </div>
            </div>

            <div class="w-full md:w-1/2 bg-white p-10 md:p-14 flex flex-col justify-center relative z-20">
                <div class="max-w-sm mx-auto w-full">
                    
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900">Sign In</h2>
                        <p class="text-sm text-gray-500 mt-1">Welcome back, Admin</p>
                    </div>

                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <x-input-error :messages="$errors->get('email')" class="mb-4" />
                    <x-input-error :messages="$errors->get('password')" class="mb-4" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Email</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 group-focus-within:text-blue-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </span>
                                <input type="email" name="email" :value="old('email')" required autofocus 
                                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition placeholder-gray-400" 
                                       placeholder="admin@example.com">
                            </div>
                        </div>

                        <div x-data="{ show: false }">
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Password</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 group-focus-within:text-blue-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </span>
                                <input :type="show ? 'text' : 'password'" name="password" required 
                                       class="w-full pl-10 pr-16 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition placeholder-gray-400" 
                                       placeholder="••••••••">
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 cursor-pointer">
                                    <span x-text="show ? 'HIDE' : 'SHOW'"></span>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 h-4 w-4">
                                <span class="ml-2 text-xs text-gray-600 font-medium">Remember me</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a class="text-xs font-bold text-blue-600 hover:text-blue-800" href="{{ route('password.request') }}">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                            Sign In
                        </button>
                    </form>

                    <div class="mt-8 text-center border-t border-gray-100 pt-4">
                        <p class="text-xs text-gray-500">
                           
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>