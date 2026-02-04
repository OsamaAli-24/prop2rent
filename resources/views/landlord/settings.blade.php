<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="flex items-center gap-3 mb-8 px-4 sm:px-0">
            <div class="p-3 bg-gray-900 dark:bg-gray-700 rounded-lg text-white shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">System Settings</h1>
                <p class="text-xs text-gray-500 dark:text-gray-400">Configure payments & license</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ activeTab: 'payment' }">
            
            <div class="col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <nav class="flex flex-col">
                        <button @click="activeTab = 'payment'" :class="activeTab === 'payment' ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 border-r-4 border-blue-600' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700'" class="px-6 py-4 text-left font-bold text-sm transition flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            Payment Methods
                        </button>
                        <button @click="activeTab = 'license'" :class="activeTab === 'license' ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-600 border-r-4 border-purple-600' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700'" class="px-6 py-4 text-left font-bold text-sm transition flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                            Purchase Key / License
                        </button>
                    </nav>
                </div>
            </div>

            <div class="col-span-2">
                
                <div x-show="activeTab === 'payment'" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Payment Configuration</h2>
                    <p class="text-sm text-gray-500 mb-6">Select how you want to receive payments from tenants.</p>

                    <div class="space-y-4">
                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="bg-green-100 p-2 rounded text-green-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                                <div>
                                    <h3 class="font-bold text-gray-800 dark:text-white">Manual Bank Transfer</h3>
                                    <p class="text-xs text-gray-500">Tenants upload payment proofs manually.</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>

                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 flex items-center justify-between opacity-50">
                            <div class="flex items-center gap-4">
                                <div class="bg-indigo-100 p-2 rounded text-indigo-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg></div>
                                <div>
                                    <h3 class="font-bold text-gray-800 dark:text-white">Credit Card (Stripe)</h3>
                                    <p class="text-xs text-gray-500">Coming soon in Pro Version.</p>
                                </div>
                            </div>
                            <span class="text-xs font-bold bg-gray-200 text-gray-500 px-2 py-1 rounded">Disabled</span>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Bank Details for Tenants</label>
                        <textarea class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg p-3 text-sm" rows="3" placeholder="Bank Name: HBL&#10;Account No: 1234-5678-90&#10;Title: John Doe"></textarea>
                        <button class="mt-3 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-700">Save Bank Details</button>
                    </div>
                </div>

                <div x-show="activeTab === 'license'" style="display: none;" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Software Activation</h2>
                    
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700 font-bold">Trial Version Active</p>
                                <p class="text-xs text-yellow-600 mt-1">Please enter your purchase key to unlock all features.</p>
                            </div>
                        </div>
                    </div>

                    <form action="#" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Purchase Key / License Code</label>
                            <input type="text" name="license_key" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg p-2 font-mono text-sm" placeholder="XXXX-XXXX-XXXX-XXXX">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Registered Email</label>
                            <input type="email" name="license_email" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg p-2 text-sm" placeholder="you@example.com">
                        </div>
                        <button type="button" onclick="alert('License Key Verified! (This is a simulation)')" class="w-full bg-purple-600 text-white px-4 py-3 rounded-lg text-sm font-bold hover:bg-purple-700 shadow-lg flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Activate License
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>