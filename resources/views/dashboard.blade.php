<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-300 px-4 py-3 rounded shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">Tenant Portal</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Welcome home, {{ Auth::user()->name }}</p>
                </div>
                <div class="hidden sm:block">
                    <span class="px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-xs font-bold uppercase tracking-wider border border-blue-200 dark:border-blue-800 flex items-center gap-2">
                        <span class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span> Active Tenant
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="space-y-6">
                    
                    <div class="relative overflow-hidden rounded-2xl shadow-xl bg-gradient-to-br from-indigo-600 to-purple-700 text-white transform transition hover:scale-[1.02] duration-300 group">
                        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white opacity-10 blur-xl group-hover:opacity-20 transition"></div>
                        <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-32 h-32 rounded-full bg-purple-400 opacity-20 blur-xl"></div>
                        
                        <div class="p-6 relative z-10">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <p class="text-[10px] font-bold text-indigo-200 uppercase tracking-widest mb-1">Current Residence</p>
                                    <h2 class="text-2xl font-black leading-tight">{{ Auth::user()->building ? Auth::user()->building->name : 'No Building' }}</h2>
                                </div>
                                <div class="p-2 bg-white/20 backdrop-blur-md rounded-lg shadow-sm">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-4 pt-4 border-t border-white/20">
                                <div>
                                    <span class="block text-[10px] text-indigo-200 uppercase font-bold">Floor Level</span>
                                    <span class="text-xl font-bold tracking-tight flex items-center gap-1">
                                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        {{ Auth::user()->floor_number ?? '-' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-[10px] text-indigo-200 uppercase font-bold">Room No.</span>
                                    <span class="text-xl font-bold tracking-tight flex items-center gap-1">
                                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                        {{ Auth::user()->room_number ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="p-5 border-b border-gray-100 dark:border-gray-700">
                            <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Financial Health</h3>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center justify-between p-4 rounded-xl mb-4 transition-colors
                                {{ $outstanding > 0 ? 'bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800' : 'bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800' }}">
                                
                                <div class="flex items-center gap-3">
                                    <div class="p-2.5 rounded-full {{ $outstanding > 0 ? 'bg-white text-red-500 shadow-sm' : 'bg-white text-green-500 shadow-sm' }}">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold {{ $outstanding > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">Total Outstanding</p>
                                        <p class="text-xl font-black text-gray-900 dark:text-white">{{ number_format($outstanding) }}</p>
                                    </div>
                                </div>
                                
                                @if($outstanding > 0)
                                    <span class="flex h-3 w-3 relative">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                    </span>
                                @else
                                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @endif
                            </div>

                            <div class="mt-4">
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-2 text-center">Need Assistance?</p>
                                <div class="grid grid-cols-2 gap-3">
                                    <a href="#" class="flex items-center justify-center py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-xs font-bold text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        Call
                                    </a>
                                    <a href="#" class="flex items-center justify-center py-2.5 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-xs font-bold text-green-700 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/30 transition gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                        WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/50">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Rent Invoices</h3>
                        <span class="bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 text-xs font-bold px-3 py-1 rounded-full">{{ $bills->count() }} Records</span>
                    </div>

                    @if($bills->isEmpty())
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 dark:bg-gray-700 mb-4">
                                <svg class="w-8 h-8 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-gray-900 dark:text-white font-bold">No Invoices Found</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">You're all caught up! No bills have been generated yet.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50 dark:bg-gray-900 text-xs uppercase text-gray-500 dark:text-gray-400 font-bold border-b border-gray-100 dark:border-gray-700">
                                    <tr>
                                        <th class="px-6 py-4">Month</th>
                                        <th class="px-6 py-4">Due Date</th>
                                        <th class="px-6 py-4">Total Amount</th>
                                        <th class="px-6 py-4">Status</th>
                                        <th class="px-6 py-4 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                                    @foreach($bills as $bill)
                                    @php 
                                        $sym = '$'; if($bill->currency == 'PKR') $sym = '₨ '; if($bill->currency == 'EUR') $sym = '€'; if($bill->currency == 'GBP') $sym = '£'; 
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition bg-white dark:bg-gray-800" x-data="{ showDetails: false, showUpload: false }">
                                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $bill->month }}</td>
                                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400 font-medium">{{ $bill->due_date ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 font-black text-gray-800 dark:text-gray-200">{{ $sym }}{{ number_format($bill->total) }}</td>
                                        <td class="px-6 py-4">
                                            @if($bill->status == 'paid')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">
                                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span> Paid
                                                </span>
                                            @elseif($bill->status == 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-1.5 animate-pulse"></span> Verifying
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800">
                                                    <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5"></span> Unpaid
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-4 text-right flex justify-end gap-2">
                                            <button @click="showDetails = true" class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 font-bold text-xs border border-gray-300 dark:border-gray-600 px-3 py-1.5 rounded-md transition bg-white dark:bg-gray-700">
                                                View
                                            </button>

                                            <a href="{{ route('tenant.invoice.download', $bill->id) }}" class="text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300 font-bold text-xs border border-purple-200 dark:border-purple-800 px-3 py-1.5 rounded-md transition bg-purple-50 dark:bg-purple-900/20" title="Download PDF">
                                                PDF
                                            </a>

                                            @if($bill->status == 'unpaid' || $bill->status == 'defaulter')
                                                <button @click="showUpload = true" class="bg-black dark:bg-white text-white dark:text-black px-3 py-1.5 rounded-md text-xs font-bold hover:bg-gray-800 dark:hover:bg-gray-200 transition shadow-sm">
                                                    Pay
                                                </button>
                                            @endif

                                            <div x-show="showDetails" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" @click="showDetails = false"></div>
                                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                                    <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-gray-200 dark:border-gray-700">
                                                        <div class="bg-white dark:bg-gray-800 p-6">
                                                            <div class="flex justify-between items-center mb-6">
                                                                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                                    Invoice Breakdown
                                                                </h3>
                                                                <button @click="showDetails = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-white bg-gray-100 dark:bg-gray-700 rounded-full p-1 transition">&times;</button>
                                                            </div>
                                                            
                                                            <div class="space-y-3">
                                                                <div class="flex justify-between text-sm py-2 border-b border-gray-100 dark:border-gray-700">
                                                                    <span class="text-gray-500 dark:text-gray-400">Base Rent</span>
                                                                    <span class="font-bold text-gray-900 dark:text-white">{{ $sym }}{{ number_format($bill->rent) }}</span>
                                                                </div>
                                                                <div class="flex justify-between text-sm py-2 border-b border-gray-100 dark:border-gray-700">
                                                                    <span class="text-gray-500 dark:text-gray-400">Maintenance</span>
                                                                    <span class="font-bold text-gray-900 dark:text-white">{{ $sym }}{{ number_format($bill->maintenance) }}</span>
                                                                </div>
                                                                @if($bill->arrears > 0)
                                                                <div class="flex justify-between text-sm py-2 border-b border-red-100 dark:border-red-900/30 bg-red-50 dark:bg-red-900/20 px-2 rounded">
                                                                    <span class="text-red-500 dark:text-red-400 font-bold">Arrears (Debt)</span>
                                                                    <span class="font-bold text-red-600 dark:text-red-400">{{ $sym }}{{ number_format($bill->arrears) }}</span>
                                                                </div>
                                                                @endif

                                                                <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg mt-3">
                                                                    <h4 class="text-xs font-bold text-gray-400 uppercase mb-2">Utilities</h4>
                                                                    
                                                                    @if($bill->electricity)
                                                                    <div class="flex justify-between items-center text-sm mb-2">
                                                                        <div class="flex items-center text-gray-700 dark:text-gray-300"><span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>Electricity</div>
                                                                        <div class="flex items-center gap-2">
                                                                            <span class="font-bold text-gray-900 dark:text-white">{{ $sym }}{{ $bill->electricity }}</span>
                                                                            @if($bill->electricity_proof)
                                                                                <a href="{{ asset('storage/'.$bill->electricity_proof) }}" target="_blank" class="flex items-center px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded text-[10px] font-bold hover:bg-yellow-200 transition">
                                                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                                                    View
                                                                                </a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    @endif

                                                                    @if($bill->water)
                                                                    <div class="flex justify-between items-center text-sm mb-2">
                                                                        <div class="flex items-center text-gray-700 dark:text-gray-300"><span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>Water</div>
                                                                        <div class="flex items-center gap-2">
                                                                            <span class="font-bold text-gray-900 dark:text-white">{{ $sym }}{{ $bill->water }}</span>
                                                                            @if($bill->water_proof)
                                                                                <a href="{{ asset('storage/'.$bill->water_proof) }}" target="_blank" class="flex items-center px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-[10px] font-bold hover:bg-blue-200 transition">
                                                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                                                    View
                                                                                </a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    @endif

                                                                    @if($bill->gas)
                                                                    <div class="flex justify-between items-center text-sm mb-2">
                                                                        <div class="flex items-center text-gray-700 dark:text-gray-300"><span class="w-2 h-2 bg-red-400 rounded-full mr-2"></span>Gas</div>
                                                                        <div class="flex items-center gap-2">
                                                                            <span class="font-bold text-gray-900 dark:text-white">{{ $sym }}{{ $bill->gas }}</span>
                                                                            @if($bill->gas_proof)
                                                                                <a href="{{ asset('storage/'.$bill->gas_proof) }}" target="_blank" class="flex items-center px-2 py-0.5 bg-red-100 text-red-700 rounded text-[10px] font-bold hover:bg-red-200 transition">
                                                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                                                    View
                                                                                </a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    @endif

                                                                    @if($bill->internet)
                                                                    <div class="flex justify-between items-center text-sm">
                                                                        <div class="flex items-center text-gray-700 dark:text-gray-300"><span class="w-2 h-2 bg-purple-400 rounded-full mr-2"></span>Internet</div>
                                                                        <div class="flex items-center gap-2">
                                                                            <span class="font-bold text-gray-900 dark:text-white">{{ $sym }}{{ $bill->internet }}</span>
                                                                            @if($bill->internet_proof)
                                                                                <a href="{{ asset('storage/'.$bill->internet_proof) }}" target="_blank" class="flex items-center px-2 py-0.5 bg-purple-100 text-purple-700 rounded text-[10px] font-bold hover:bg-purple-200 transition">
                                                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                                                    View
                                                                                </a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                </div>

                                                                @if($bill->notes)
                                                                    <div class="mt-3 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-100 dark:border-yellow-900 rounded text-xs text-yellow-800 dark:text-yellow-400 italic">
                                                                        <strong>Note:</strong> {{ $bill->notes }}
                                                                    </div>
                                                                @endif

                                                                <div class="flex justify-between text-lg font-black pt-4 border-t border-gray-200 dark:border-gray-600 mt-2 text-gray-900 dark:text-white">
                                                                    <span>Grand Total</span>
                                                                    <span>{{ $sym }}{{ number_format($bill->total) }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div x-show="showUpload" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" @click="showUpload = false"></div>
                                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                                    <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700">
                                                        <form action="{{ route('tenant.upload', $bill->id) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white mb-2" id="modal-title">Upload Payment Proof</h3>
                                                                <div class="mt-2">
                                                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Please upload a clear screenshot of your bank transfer or payment receipt.</p>
                                                                    <input type="file" name="payment_proof" class="w-full border border-gray-300 dark:border-gray-600 rounded p-2 text-sm bg-gray-50 dark:bg-gray-700 dark:text-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                                                                </div>
                                                            </div>
                                                            <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100 dark:border-gray-700">
                                                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                                                    Submit Proof
                                                                </button>
                                                                <button type="button" @click="showUpload = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>