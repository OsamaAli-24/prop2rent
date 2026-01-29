<nav x-data="{ open: false }" class="bg-white/95 backdrop-blur-sm border-b border-purple-100 shadow-sm shadow-purple-50/50 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <div class="flex items-center gap-2 cursor-default select-none">
                        <div class="bg-gradient-to-tr from-purple-600 to-blue-500 p-1.5 rounded-lg text-white shadow-sm">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <span class="font-bold text-xl text-gray-900 tracking-tight">
                            Building <span class="text-purple-600">Management</span>
                        </span>
                    </div>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center font-medium">
                    
                    @if(Auth::user()->role === 'landlord')
                        <x-nav-link :href="route('landlord.dashboard')" :active="request()->routeIs('landlord.dashboard')" class="text-gray-700 hover:text-purple-700 transition">
                            {{ __('Landlord Panel') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-700 hover:text-purple-700 transition">
                            {{ __('My Dashboard') }}
                        </x-nav-link>
                    @endif

                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-bold rounded-full text-gray-700 bg-purple-50 hover:bg-purple-100 hover:text-purple-800 focus:outline-none transition ease-in-out duration-300 shadow-sm">
                            <div class="flex items-center">
                                <div class="w-6 h-6 rounded-full bg-purple-200 text-purple-700 flex items-center justify-center text-xs mr-2">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                {{ Auth::user()->name }}
                            </div>

                            <div class="ml-2">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-gray-100 text-xs text-gray-400 uppercase font-bold tracking-wider">
                            Account Management
                        </div>
                        
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-purple-50 hover:text-purple-700 transition">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        @if(Auth::user()->role === 'landlord')
                            <x-dropdown-link :href="route('landlord.settings')" class="hover:bg-purple-50 hover:text-purple-700 transition">
                                {{ __('Settings') }}
                            </x-dropdown-link>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="hover:bg-red-50 hover:text-red-700 transition text-red-600">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-purple-600 hover:bg-purple-50 focus:outline-none focus:bg-purple-50 focus:text-purple-600 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-b border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->role === 'landlord')
                <x-responsive-nav-link :href="route('landlord.dashboard')" :active="request()->routeIs('landlord.dashboard')" class="hover:bg-purple-50 hover:text-purple-700">
                    {{ __('Landlord Panel') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="hover:bg-purple-50 hover:text-purple-700">
                    {{ __('My Dashboard') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 bg-gray-50">
            <div class="px-4 flex items-center">
                 <div class="w-8 h-8 rounded-full bg-purple-200 text-purple-700 flex items-center justify-center text-sm font-bold mr-3">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="hover:bg-purple-50">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if(Auth::user()->role === 'landlord')
                    <x-responsive-nav-link :href="route('landlord.settings')" class="hover:bg-purple-50">
                        {{ __('Settings') }}
                    </x-responsive-nav-link>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                             class="hover:bg-red-50 text-red-600">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>