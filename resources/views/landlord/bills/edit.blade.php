<x-app-layout>
    <div class="py-12 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl overflow-hidden transition-colors duration-200">
            
            <div class="bg-purple-600 p-6 flex justify-between items-center">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Invoice #{{ $bill->id }}
                </h2>
                <a href="{{ route('landlord.dashboard') }}" class="text-purple-100 hover:text-white text-sm font-bold flex items-center">
                    &larr; Back to Dashboard
                </a>
            </div>

            <form action="{{ route('landlord.bill.update', $bill->id) }}" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf
                @method('PUT')

                <div class="mb-6 bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-100 dark:border-gray-600">
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Tenant</label>
                    <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $bill->tenant->name }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $bill->tenant->building->name ?? 'No Building' }} • Room {{ $bill->tenant->room_number ?? 'N/A' }}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Billing Month</label>
                        <input type="text" name="month" value="{{ $bill->month }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Due Date</label>
                        <input type="date" name="due_date" value="{{ $bill->due_date }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Currency</label>
                        <select name="currency" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm font-bold">
                            <option value="USD" {{ $bill->currency == 'USD' ? 'selected' : '' }}>USD ($)</option>
                            <option value="PKR" {{ $bill->currency == 'PKR' ? 'selected' : '' }}>PKR (₨)</option>
                            <option value="EUR" {{ $bill->currency == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                            <option value="GBP" {{ $bill->currency == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                        </select>
                    </div>
                </div>

                <hr class="my-6 border-gray-100 dark:border-gray-700">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Base Rent</label>
                        <div class="relative">
                            <input type="number" name="rent" value="{{ $bill->rent }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm font-bold text-lg" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Maintenance</label>
                        <div class="relative">
                            <input type="number" name="maintenance" value="{{ $bill->maintenance }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm">
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/10 p-5 rounded-xl border border-blue-100 dark:border-blue-800 mb-6">
                    <h3 class="text-sm font-bold text-blue-800 dark:text-blue-300 uppercase mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Update Utilities & Proofs
                    </h3>
                    
                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-4 items-center border-b border-blue-100 dark:border-blue-800/50 pb-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 uppercase">Electricity Cost</label>
                                <input type="number" name="electricity" value="{{ $bill->electricity }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded text-sm font-bold">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 uppercase">Proof File</label>
                                <div class="flex items-center gap-2">
                                    <input type="file" name="electricity_proof" class="text-xs w-full text-gray-500 dark:text-gray-300">
                                    @if($bill->electricity_proof)
                                        <a href="{{ asset('storage/'.$bill->electricity_proof) }}" target="_blank" class="flex-shrink-0 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 text-blue-600 dark:text-blue-400 px-2 py-1 rounded text-xs font-bold hover:bg-gray-50">View</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 items-center border-b border-blue-100 dark:border-blue-800/50 pb-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 uppercase">Water Cost</label>
                                <input type="number" name="water" value="{{ $bill->water }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded text-sm font-bold">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 uppercase">Proof File</label>
                                <div class="flex items-center gap-2">
                                    <input type="file" name="water_proof" class="text-xs w-full text-gray-500 dark:text-gray-300">
                                    @if($bill->water_proof)
                                        <a href="{{ asset('storage/'.$bill->water_proof) }}" target="_blank" class="flex-shrink-0 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 text-blue-600 dark:text-blue-400 px-2 py-1 rounded text-xs font-bold hover:bg-gray-50">View</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 items-center border-b border-blue-100 dark:border-blue-800/50 pb-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 uppercase">Gas Cost</label>
                                <input type="number" name="gas" value="{{ $bill->gas }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded text-sm font-bold">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 uppercase">Proof File</label>
                                <div class="flex items-center gap-2">
                                    <input type="file" name="gas_proof" class="text-xs w-full text-gray-500 dark:text-gray-300">
                                    @if($bill->gas_proof)
                                        <a href="{{ asset('storage/'.$bill->gas_proof) }}" target="_blank" class="flex-shrink-0 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 text-blue-600 dark:text-blue-400 px-2 py-1 rounded text-xs font-bold hover:bg-gray-50">View</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 items-center">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 uppercase">Internet Cost</label>
                                <input type="number" name="internet" value="{{ $bill->internet }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded text-sm font-bold">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1 uppercase">Proof File</label>
                                <div class="flex items-center gap-2">
                                    <input type="file" name="internet_proof" class="text-xs w-full text-gray-500 dark:text-gray-300">
                                    @if($bill->internet_proof)
                                        <a href="{{ asset('storage/'.$bill->internet_proof) }}" target="_blank" class="flex-shrink-0 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 text-blue-600 dark:text-blue-400 px-2 py-1 rounded text-xs font-bold hover:bg-gray-50">View</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Notes / Remarks</label>
                    <textarea name="notes" rows="3" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm">{{ $bill->notes }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('landlord.dashboard') }}" class="text-gray-500 font-bold text-sm hover:underline dark:text-gray-400">Cancel</a>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition transform hover:scale-105">
                        Update Invoice
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout> 