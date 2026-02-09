<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 cursor-default select-none">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 transition-colors duration-200">
            
            <div class="flex flex-col xl:flex-row justify-between items-center mb-8 gap-4">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-black dark:bg-purple-600 rounded-lg text-white shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white leading-none">Landlord Dashboard</h1>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">Manage your properties & tenants</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 justify-center xl:justify-end">
                    
                    <div x-data="tenantManager()" class="relative">
                        <button @click="open = true" 
                                class="flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition shadow-lg text-sm font-bold">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span>Manage</span>
                        </button>
                        
                        <div x-show="open" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center px-4" x-transition>
                            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm" @click="open = false"></div>
                            
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md relative z-10 overflow-hidden max-h-[80vh] flex flex-col">
                                <div class="p-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex justify-between items-center">
                                    <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Current Tenants List</h3>
                                    <button @click="open = false" class="text-gray-400 hover:text-gray-600">&times;</button>
                                </div>
                                
                                <div class="overflow-y-auto p-2">
                                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                                        @if($tenants->isEmpty())
                                            <div class="p-4 text-center text-xs text-gray-400">No tenants found.</div>
                                        @else
                                            @foreach($tenants as $tenant)
                                            <div class="p-3 flex justify-between items-center hover:bg-gray-50 dark:hover:bg-gray-700 transition rounded-lg">
                                                <div class="flex items-center gap-3 overflow-hidden">
                                                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">
                                                        {{ substr($tenant->name, 0, 1) }}
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200 truncate">{{ $tenant->name }}</p>
                                                        <p class="text-[10px] text-gray-500 dark:text-gray-400 truncate">
                                                            @if($tenant->building) {{ $tenant->building->name }} @else Unassigned @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                <div class="flex items-center gap-1">
                                                    <button @click="viewTenant({{ $tenant->id }})" class="p-2 text-blue-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-full transition" title="View Details">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    </button>
                                                    <form action="{{ route('landlord.tenant.destroy', $tenant->id) }}" method="POST" onsubmit="return confirm('WARNING: Deleting this tenant will remove all their billing history. Continue?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-full transition" title="Delete Tenant">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-center justify-center min-h-screen p-4 text-center">
                                <div class="fixed inset-0 bg-gray-900 bg-opacity-80 transition-opacity backdrop-blur-sm" @click="showModal = false"></div>
                                <div class="inline-block bg-white dark:bg-gray-800 rounded-xl text-left overflow-hidden shadow-2xl transform transition-all w-full max-w-lg border border-gray-200 dark:border-gray-700 relative z-10">
                                    <div class="bg-gradient-to-r from-purple-600 to-blue-600 px-6 py-4">
                                        <div class="flex justify-between items-center">
                                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                Tenant Profile
                                            </h3>
                                            <button @click="showModal = false" class="text-white hover:text-gray-200">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="p-6">
                                        <div class="flex items-center gap-4 mb-6">
                                            <div class="w-16 h-16 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-2xl font-bold text-gray-500 dark:text-gray-400">
                                                <span x-text="selectedTenant.initial"></span>
                                            </div>
                                            <div>
                                                <h2 class="text-xl font-bold text-gray-900 dark:text-white" x-text="selectedTenant.name"></h2>
                                                <p class="text-sm text-gray-500 dark:text-gray-400" x-text="selectedTenant.email"></p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                    <span x-text="selectedTenant.phone"></span>
                                                </p>
                                                <p class="text-xs text-blue-500 font-bold mt-1">Joined: <span x-text="selectedTenant.joined"></span></p>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4 mb-6">
                                            <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg border border-gray-100 dark:border-gray-600">
                                                <span class="text-[10px] uppercase font-bold text-gray-400 block">Total Paid</span>
                                                <span class="text-lg font-bold text-green-600" x-text="selectedTenant.total_paid"></span>
                                            </div>
                                            <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg border border-gray-100 dark:border-gray-600">
                                                <span class="text-[10px] uppercase font-bold text-gray-400 block">Pending Dues</span>
                                                <span class="text-lg font-bold text-red-500" x-text="selectedTenant.total_pending"></span>
                                            </div>
                                        </div>
                                        <div class="border-t border-gray-100 dark:border-gray-700 pt-4">
                                            <h4 class="text-xs font-bold text-gray-500 uppercase mb-3">Residence Info</h4>
                                            <div class="flex justify-between text-sm mb-2">
                                                <span class="text-gray-600 dark:text-gray-400">Building:</span>
                                                <span class="font-bold text-gray-900 dark:text-white" x-text="selectedTenant.building"></span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600 dark:text-gray-400">Room / Unit:</span>
                                                <span class="font-bold text-gray-900 dark:text-white" x-text="selectedTenant.room"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-900 px-6 py-3 flex justify-end rounded-b-xl border-t border-gray-100 dark:border-gray-700">
                                        <button @click="showModal = false" class="text-sm font-bold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-data="tenantForm()" class="relative">
                        <button @click="open = true" 
                                class="flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition shadow-lg text-sm font-bold">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            <span>+ Tenant</span>
                        </button>
                        
                        <div x-show="open" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center px-4" x-transition>
                            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm" @click="open = false"></div>
                            
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md relative z-10 overflow-hidden max-h-[90vh] flex flex-col">
                                <div class="p-5 overflow-y-auto">
                                    <div class="flex justify-between items-center border-b border-gray-100 dark:border-gray-700 pb-2 mb-3">
                                        <h3 class="text-xs font-bold text-green-700 dark:text-green-400 uppercase tracking-wider flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            Register Tenant
                                        </h3>
                                        <button @click="open = false" class="text-gray-400 hover:text-gray-600">&times;</button>
                                    </div>

                                    <form action="{{ route('landlord.tenant.store') }}" method="POST" class="space-y-3">
                                        @csrf
                                        <div><label class="block text-xs font-bold text-gray-600 dark:text-gray-300">Name</label><input type="text" name="name" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md text-sm p-2 focus:ring-green-500" required></div>
                                        <div><label class="block text-xs font-bold text-gray-600 dark:text-gray-300">Email</label><input type="email" name="email" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md text-sm p-2 focus:ring-green-500" required></div>
                                        
                                        <div><label class="block text-xs font-bold text-gray-600 dark:text-gray-300">Contact Number</label><input type="text" name="phone" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md text-sm p-2 focus:ring-green-500" placeholder="+1234567890"></div>
                                        
                                        <div><label class="block text-xs font-bold text-gray-600 dark:text-gray-300">Password</label><input type="password" name="password" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md text-sm p-2 focus:ring-green-500" required></div>
                                        
                                        <div class="bg-gray-50 dark:bg-gray-900 p-3 rounded border border-gray-100 dark:border-gray-700">
                                            <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase mb-2">Assign Location(s)</label>
                                            
                                            <select name="building_id" x-model="selectedBuildingId" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md text-xs p-2 mb-3 focus:ring-green-500 font-bold">
                                                <option value="" disabled selected>Select Building...</option>
                                                <template x-for="b in buildingsData" :key="b.id">
                                                    <option :value="b.id" x-text="b.name"></option>
                                                </template>
                                            </select>

                                            <div class="space-y-2" x-show="selectedBuildingId">
                                                <template x-for="(unit, index) in units" :key="index">
                                                    <div class="flex gap-2 items-center bg-white dark:bg-gray-800 p-2 rounded border border-gray-200 dark:border-gray-600">
                                                        
                                                        <div class="flex-1">
                                                            <label class="text-[9px] text-gray-400 font-bold uppercase block mb-1">Floor</label>
                                                            <select :name="'units['+index+'][floor]'" x-model="unit.floor" class="w-full border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md text-xs p-1 h-8">
                                                                <option value="">Select...</option>
                                                                <template x-for="f in availableFloors" :key="f.name">
                                                                    <option :value="f.name" x-text="'Floor ' + f.name + getFloorLabel(f.type)"></option>
                                                                </template>
                                                            </select>
                                                        </div>

                                                        <div class="flex-1">
                                                            <label class="text-[9px] text-gray-400 font-bold uppercase block mb-1">Unit</label>
                                                            <select :name="'units['+index+'][room]'" x-model="unit.room" class="w-full border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md text-xs p-1 h-8" :disabled="!unit.floor">
                                                                <option value="">Select...</option>
                                                                <template x-for="r in getRoomsForFloor(unit.floor)" :key="r.number">
                                                                    <option :value="r.number" 
                                                                            :disabled="r.status === 'Occupied'"
                                                                            :class="r.status === 'Occupied' ? 'text-red-400 bg-red-50 dark:bg-gray-900' : 'text-green-600 font-bold'"
                                                                            x-text="r.label + ' (' + r.status + ')'">
                                                                    </option>
                                                                </template>
                                                            </select>
                                                        </div>

                                                        <button type="button" @click="if(units.length > 1) units.splice(index, 1)" class="text-red-400 hover:text-red-600 mt-4" title="Remove">&times;</button>
                                                    </div>
                                                </template>
                                            </div>

                                            <button type="button" x-show="selectedBuildingId" @click="units.push({ floor: '', room: '' })" class="mt-3 text-xs text-blue-600 dark:text-blue-400 font-bold hover:underline flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                Add Another Unit
                                            </button>
                                        </div>

                                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded text-sm mt-2 shadow-md">Create & Assign</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-data="{ 
                        showBuildingModal: false,
                        floorFormat: 'standard', 
                        totalFloors: 3, 
                        floors: [],
                        
                        generateFloors() {
                            this.floors = [];
                            let count = 0;
                            let floorNum = 1;

                            if (this.floorFormat === 'basement') {
                                if (this.totalFloors > count) { this.floors.push({ name: 'Basement', type: 'academic' }); count++; }
                                if (this.totalFloors > count) { this.floors.push({ name: 'Ground Floor', type: 'academic' }); count++; }
                            } else if (this.floorFormat === 'ground') {
                                if (this.totalFloors > count) { this.floors.push({ name: 'Ground Floor', type: 'academic' }); count++; }
                            }

                            while (count < this.totalFloors) {
                                this.floors.push({ name: 'Floor ' + floorNum, type: 'academic' });
                                floorNum++;
                                count++;
                            }
                        }
                    }">
                        <button @click="showBuildingModal = true; generateFloors()" 
                                class="flex items-center px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-lg transition shadow-lg text-sm font-bold">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span>+ Building</span>
                        </button>

                        <div x-show="showBuildingModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" @click="showBuildingModal = false"></div>

                                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700">
                                    <form action="{{ route('landlord.building.store') }}" method="POST">
                                        @csrf
                                        
                                        <div class="bg-white dark:bg-gray-800 px-6 pt-6 pb-4">
                                            <div class="mb-4">
                                                <input type="text" name="name" class="w-full border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white rounded-lg text-lg font-bold p-3 focus:ring-purple-500 focus:border-purple-500" placeholder="Building Name" required>
                                            </div>

                                            <div class="bg-blue-50 dark:bg-blue-900/10 p-4 rounded-xl border border-blue-100 dark:border-blue-800 mb-6">
                                                <div class="mb-3">
                                                    <label class="block text-[10px] font-bold text-blue-800 dark:text-blue-300 uppercase mb-1">Numbering Format</label>
                                                    <select x-model="floorFormat" class="w-full border-gray-200 dark:border-gray-600 rounded-md text-sm p-2 focus:ring-blue-500 font-bold bg-white dark:bg-gray-700 dark:text-white">
                                                        <option value="standard">Floor 1 ➔ Floor 2 ➔ Floor 3...</option>
                                                        <option value="ground">Ground ➔ Floor 1 ➔ Floor 2...</option>
                                                        <option value="basement">Basement ➔ Ground ➔ Floor 1...</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-bold text-blue-800 dark:text-blue-300 uppercase mb-1">Total Levels</label>
                                                    <div class="flex gap-2">
                                                        <input type="number" x-model="totalFloors" min="1" max="50" class="w-full border-gray-200 dark:border-gray-600 rounded-md text-sm p-2 text-center font-bold dark:bg-gray-700 dark:text-white">
                                                        <button type="button" @click="generateFloors()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-xs font-bold shadow-sm whitespace-nowrap transition">
                                                            SET FLOORS
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($errors->any())
                                                <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-xs font-bold">
                                                    <p>• The floors field is required.</p>
                                                </div>
                                            @endif

                                            <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                                                <template x-for="(floor, index) in floors" :key="index">
                                                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-white dark:bg-gray-800 shadow-sm relative">
                                                        <input type="hidden" :name="'floors['+index+'][name]'" :value="floor.name">
                                                        
                                                        <div class="flex justify-between items-center mb-3">
                                                            <span class="bg-black text-white text-[10px] font-bold px-2 py-1 rounded" x-text="floor.name"></span>
                                                            <button type="button" @click="floors.splice(index, 1)" class="text-blue-200 hover:text-red-500">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                            </button>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Floor Use</label>
                                                            <select :name="'floors['+index+'][type]'" x-model="floor.type" class="w-full border-gray-200 dark:border-gray-600 rounded-md text-sm p-2 font-medium bg-white dark:bg-gray-700 dark:text-white">
                                                                <option value="academic">💼 Corporate / Office</option>
                                                                <option value="residential">🛏️ Apartment / Residential</option>
                                                            </select>
                                                        </div>

                                                        <div class="grid grid-cols-2 gap-3">
                                                            <div>
                                                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1" x-text="floor.type === 'residential' ? 'ROOMS' : 'OFFICES'"></label>
                                                                <input type="number" :name="'floors['+index+'][offices]'" placeholder="0" class="w-full border-gray-200 dark:border-gray-600 rounded-md text-sm p-2 dark:bg-gray-700 dark:text-white">
                                                            </div>
                                                            <div>
                                                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">WASHROOMS</label>
                                                                <input type="number" :name="'floors['+index+'][washrooms]'" placeholder="0" class="w-full border-gray-200 dark:border-gray-600 rounded-md text-sm p-2 dark:bg-gray-700 dark:text-white">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>

                                        <div class="bg-gray-50 dark:bg-gray-900 px-6 py-4 flex justify-end gap-3 rounded-b-xl border-t border-gray-100 dark:border-gray-700">
                                            <button type="button" @click="showBuildingModal = false" class="text-gray-500 font-bold text-sm hover:underline">Cancel</button>
                                            <button type="submit" class="bg-gray-900 hover:bg-black text-white font-bold py-2 px-6 rounded-lg shadow-lg">Save Building</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-data="{ 
                            open: false, rent: 0, maintenance: 0, arrears: 0, currency: 'USD',
                            selectedUtility: '', showElec: false, showWater: false, showGas: false, showInternet: false, 
                            elec: 0, water: 0, gas: 0, internet: 0,
                            get symbol() { if(this.currency === 'USD') return '$'; if(this.currency === 'PKR') return '₨ '; if(this.currency === 'EUR') return '€'; if(this.currency === 'GBP') return '£'; return '$'; },
                            get totalUtilities() { return parseInt(this.elec || 0) + parseInt(this.water || 0) + parseInt(this.gas || 0) + parseInt(this.internet || 0); },
                            get grandTotal() { return parseInt(this.rent || 0) + this.totalUtilities + parseInt(this.maintenance || 0) + parseInt(this.arrears || 0); }
                          }" class="relative">
                        <button @click="open = true" class="flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition shadow-lg text-sm font-bold">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span>+ Create Invoice</span>
                        </button>
                        
                        <div x-show="open" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center px-4" x-transition>
                            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm" @click="open = false"></div>
                            
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-lg relative z-10 overflow-hidden max-h-[90vh] flex flex-col">
                                <div class="bg-blue-600 p-4 text-white flex justify-between items-center shadow-md">
                                    <h3 class="font-bold uppercase tracking-wide text-xs">New Invoice & Proofs</h3>
                                    <button @click="open = false" class="text-blue-200 hover:text-white">&times;</button>
                                </div>
                                <div class="p-5 overflow-y-auto">
                                    <form action="{{ route('landlord.bill.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="grid grid-cols-2 gap-3 mb-4">
                                            <div class="col-span-2">
                                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Tenant</label>
                                                <select name="tenant_id" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm bg-gray-50 p-2 font-bold">
                                                    @foreach($tenants as $tenant)<option value="{{ $tenant->id }}">{{ $tenant->name }}</option>@endforeach
                                                </select>
                                            </div>
                                            <div><label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Billing Month</label><input type="text" name="month" placeholder="Feb 2026" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm p-2" required></div>
                                            <div><label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Due Date</label><input type="date" name="due_date" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm p-2"></div>
                                        </div>
                                        <div class="mb-4 flex gap-3">
                                            <div class="w-1/3">
                                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Currency</label>
                                                <select name="currency" x-model="currency" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm p-2 font-bold text-blue-800 dark:text-blue-400"><option value="USD">USD ($)</option><option value="PKR">PKR (₨)</option><option value="EUR">EUR (€)</option><option value="GBP">GBP (£)</option></select>
                                            </div>
                                            <div class="w-2/3"><label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Base Rent</label><input type="number" x-model="rent" name="rent" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm p-2 font-bold" required></div>
                                        </div>
                                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-100 dark:border-blue-800 mb-4">
                                            <div class="flex justify-between items-center mb-3">
                                                <span class="text-xs font-bold text-blue-800 dark:text-blue-300">Utilities & Proofs</span>
                                                <select x-model="selectedUtility" @change="if(selectedUtility) { if(selectedUtility=='elec') showElec=true; if(selectedUtility=='water') showWater=true; if(selectedUtility=='gas') showGas=true; if(selectedUtility=='net') showInternet=true; selectedUtility=''; }" class="text-[10px] border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded h-7 py-0 shadow-sm">
                                                    <option value="">+ Add Utility</option><option value="elec">Electricity</option><option value="water">Water</option><option value="gas">Gas</option><option value="net">Internet</option>
                                                </select>
                                            </div>
                                            <div class="space-y-3">
                                                <template x-if="showElec"><div class="flex items-center gap-2 bg-white dark:bg-gray-700 p-2 rounded border border-gray-200 dark:border-gray-600 shadow-sm"><div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-[10px]">⚡</div><div class="flex-1"><label class="text-[9px] font-bold text-gray-400 block uppercase">Cost</label><input type="number" name="electricity" x-model="elec" class="w-full h-6 text-xs border-0 p-0 focus:ring-0 font-bold dark:bg-gray-700 dark:text-white"></div><div class="flex-1 border-l dark:border-gray-600 pl-2"><label class="text-[9px] font-bold text-gray-400 block uppercase">Proof</label><input type="file" name="electricity_proof" class="text-[9px] w-full dark:text-gray-300"></div><button type="button" @click="showElec=false; elec=0" class="text-red-400 hover:text-red-600">&times;</button></div></template>
                                                <template x-if="showWater"><div class="flex items-center gap-2 bg-white dark:bg-gray-700 p-2 rounded border border-gray-200 dark:border-gray-600 shadow-sm"><div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-[10px]">💧</div><div class="flex-1"><label class="text-[9px] font-bold text-gray-400 block uppercase">Cost</label><input type="number" name="water" x-model="water" class="w-full h-6 text-xs border-0 p-0 focus:ring-0 font-bold dark:bg-gray-700 dark:text-white"></div><div class="flex-1 border-l dark:border-gray-600 pl-2"><label class="text-[9px] font-bold text-gray-400 block uppercase">Proof</label><input type="file" name="water_proof" class="text-[9px] w-full dark:text-gray-300"></div><button type="button" @click="showWater=false; water=0" class="text-red-400 hover:text-red-600">&times;</button></div></template>
                                                <template x-if="showGas"><div class="flex items-center gap-2 bg-white dark:bg-gray-700 p-2 rounded border border-gray-200 dark:border-gray-600 shadow-sm"><div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-[10px]">🔥</div><div class="flex-1"><label class="text-[9px] font-bold text-gray-400 block uppercase">Cost</label><input type="number" name="gas" x-model="gas" class="w-full h-6 text-xs border-0 p-0 focus:ring-0 font-bold dark:bg-gray-700 dark:text-white"></div><div class="flex-1 border-l dark:border-gray-600 pl-2"><label class="text-[9px] font-bold text-gray-400 block uppercase">Proof</label><input type="file" name="gas_proof" class="text-[9px] w-full dark:text-gray-300"></div><button type="button" @click="showGas=false; gas=0" class="text-red-400 hover:text-red-600">&times;</button></div></template>
                                                <template x-if="showInternet"><div class="flex items-center gap-2 bg-white dark:bg-gray-700 p-2 rounded border border-gray-200 dark:border-gray-600 shadow-sm"><div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-[10px]">📶</div><div class="flex-1"><label class="text-[9px] font-bold text-gray-400 block uppercase">Cost</label><input type="number" name="internet" x-model="internet" class="w-full h-6 text-xs border-0 p-0 focus:ring-0 font-bold dark:bg-gray-700 dark:text-white"></div><div class="flex-1 border-l dark:border-gray-600 pl-2"><label class="text-[9px] font-bold text-gray-400 block uppercase">Proof</label><input type="file" name="internet_proof" class="text-[9px] w-full dark:text-gray-300"></div><button type="button" @click="showInternet=false; internet=0" class="text-red-400 hover:text-red-600">&times;</button></div></template>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-3 mb-3">
                                            <div><label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Maintenance</label><input type="number" x-model="maintenance" name="maintenance" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm p-2" placeholder="0"></div>
                                            <div><label class="block text-[10px] font-bold text-red-400 uppercase mb-1">Arrears (Debt)</label><input type="number" x-model="arrears" name="arrears" class="w-full border-red-200 bg-red-50 dark:bg-red-900/30 dark:border-red-900 text-red-700 dark:text-red-400 font-bold rounded-lg text-sm p-2" placeholder="0"></div>
                                            <div class="col-span-2"><label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Notes / Remarks</label><textarea name="notes" rows="2" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-xs p-2" placeholder="Add remarks..."></textarea></div>
                                        </div>
                                        <div class="bg-gray-900 dark:bg-black text-white p-4 rounded-xl flex justify-between items-center shadow-lg"><div class="text-xs text-gray-400 font-medium">Grand Total</div><div class="text-xl font-black" x-text="symbol + grandTotal"></div></div>
                                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg text-sm mt-4 shadow-lg transform hover:scale-[1.01] transition">Confirm & Generate</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                @if(session('success'))
                    <div class="bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-300 px-4 py-3 rounded shadow-sm flex items-center mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-300 px-4 py-3 rounded shadow-sm flex items-center mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-bold">{{ session('error') }}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-300 px-4 py-3 rounded shadow-sm">
                        <ul class="list-disc list-inside text-sm font-bold">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
            </div>

            <div class="mb-8">
                <div class="flex justify-end mb-4">
                    <form action="{{ route('landlord.dashboard') }}" method="GET" class="flex items-center gap-2 bg-purple-50 dark:bg-gray-700 p-1.5 rounded-lg border border-purple-100 dark:border-gray-600 shadow-sm">
                        <label class="text-[10px] font-bold text-purple-700 dark:text-purple-300 uppercase px-2">Show Currency:</label>
                        <select name="currency" onchange="this.form.submit()" class="text-xs border-none focus:ring-0 bg-white dark:bg-gray-800 dark:text-white rounded-md font-bold text-gray-700 cursor-pointer py-1 pl-2 pr-8 shadow-sm">
                            <option value="USD" {{ $selectedCurrency == 'USD' ? 'selected' : '' }}>🇺🇸 USD ($)</option>
                            <option value="PKR" {{ $selectedCurrency == 'PKR' ? 'selected' : '' }}>🇵🇰 PKR (₨)</option>
                            <option value="EUR" {{ $selectedCurrency == 'EUR' ? 'selected' : '' }}>🇪🇺 EUR (€)</option>
                            <option value="GBP" {{ $selectedCurrency == 'GBP' ? 'selected' : '' }}>🇬🇧 GBP (£)</option>
                        </select>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between hover:shadow-md transition">
                        <div><p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Total Revenue ({{ $selectedCurrency }})</p><h3 class="text-2xl font-black text-gray-800 dark:text-white mt-1">{{ $currencySymbol }}{{ number_format($totalReceived) }}</h3></div>
                        <div class="p-3 bg-green-50 dark:bg-green-900/30 rounded-full text-green-600 dark:text-green-400"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between hover:shadow-md transition">
                        <div><p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Pending ({{ $selectedCurrency }})</p><h3 class="text-2xl font-black text-red-600 dark:text-red-400 mt-1">{{ $currencySymbol }}{{ number_format($totalPending) }}</h3></div>
                        <div class="p-3 bg-red-50 dark:bg-red-900/30 rounded-full text-red-500 dark:text-red-400"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between hover:shadow-md transition">
                        <div><p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Occupants</p><h3 class="text-2xl font-black text-blue-900 dark:text-blue-300 mt-1">{{ $totalTenants }}</h3></div>
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-full text-blue-600 dark:text-blue-400"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between hover:shadow-md transition">
                        <div><p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Properties</p><h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $totalBuildings }}</h3></div>
                        <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-full text-gray-600 dark:text-gray-300"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg></div>
                    </div>
                </div>
            </div>

            <div class="mb-10">
                <div class="flex items-center gap-2 mb-4"><div class="w-1 h-6 bg-blue-600 rounded-full"></div><h2 class="font-bold text-lg text-gray-800 dark:text-white">Recent Transactions</h2></div>
                <div class="overflow-x-auto shadow-sm rounded-xl border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full bg-white dark:bg-gray-800">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-700">
                                <th class="p-4 text-left font-bold text-[10px] text-gray-400 uppercase tracking-wider">Tenant / Location</th>
                                <th class="p-4 text-left font-bold text-[10px] text-gray-400 uppercase tracking-wider">Period</th>
                                <th class="p-4 text-left font-bold text-[10px] text-gray-400 uppercase tracking-wider">Amount</th>
                                <th class="p-4 text-left font-bold text-[10px] text-gray-400 uppercase tracking-wider">Proof</th>
                                <th class="p-4 text-left font-bold text-[10px] text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="p-4 text-left font-bold text-[10px] text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                            @foreach($bills as $bill)
                            @php $sym = '$'; if($bill->currency == 'PKR') $sym = '₨ '; if($bill->currency == 'EUR') $sym = '€'; if($bill->currency == 'GBP') $sym = '£'; @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition group">
                                <td class="p-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center text-xs font-bold mr-3">{{ substr($bill->tenant->name, 0, 1) }}</div>
                                        <div><div class="text-sm font-bold text-gray-900 dark:text-white">{{ $bill->tenant->name }}</div>@if($bill->tenant->building)<div class="text-[10px] text-gray-400 flex items-center">{{ $bill->tenant->building->name }} @if($bill->tenant->room_number) <span class="mx-1">•</span> Rm {{ $bill->tenant->room_number }} @endif</div>@endif</div>
                                    </div>
                                </td>
                                <td class="p-4 text-sm text-gray-600 dark:text-gray-300 font-medium">{{ $bill->month }}</td>
                                <td class="p-4 text-sm font-bold text-gray-900 dark:text-white">{{ $sym }}{{ $bill->total }}</td>
                                <td class="p-4">
                                    @if($bill->payment_proof)
                                        <a href="{{ route('landlord.proof.download', $bill->id) }}" class="inline-flex items-center px-2 py-1 rounded text-xs font-bold text-white bg-red-500 hover:bg-red-600 transition shadow-sm mr-2"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> PDF</a>
                                        <a href="/get_proof.php?img={{ $bill->payment_proof }}" target="_blank" class="ml-1 text-gray-400 hover:text-blue-600 dark:text-gray-500 dark:hover:text-blue-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></a>
                                    @else <span class="text-gray-300 dark:text-gray-600 text-xl leading-none">&bull;</span> @endif
                                </td>
                                <td class="p-4">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide border {{ $bill->status == 'paid' ? 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border-green-100 dark:border-green-800' : ($bill->status == 'defaulter' ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-red-100 dark:border-red-800' : 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-400 border-yellow-100 dark:border-yellow-800') }}"><span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $bill->status == 'paid' ? 'bg-green-500' : ($bill->status == 'defaulter' ? 'bg-red-500' : 'bg-yellow-500') }}"></span>{{ $bill->status }}</span>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('landlord.bill.status', $bill->id) }}" method="POST">@csrf @method('PATCH')<select name="status" onchange="this.form.submit()" class="text-xs border-gray-200 dark:border-gray-600 rounded shadow-sm p-1.5 focus:border-blue-500 focus:ring-blue-500 bg-white dark:bg-gray-700 dark:text-white cursor-pointer w-24"><option value="unpaid" {{ $bill->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option><option value="paid" {{ $bill->status == 'paid' ? 'selected' : '' }}>Paid</option><option value="defaulter" {{ $bill->status == 'defaulter' ? 'selected' : '' }}>Defaulter</option></select></form>
                                        <a href="{{ route('landlord.bill.edit', $bill->id) }}" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition" title="Edit Bill"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>
                                        <form action="{{ route('landlord.bill.destroy', $bill->id) }}" method="POST" onsubmit="return confirm('Are you sure? This will permanently delete this invoice.');">@csrf @method('DELETE')<button type="submit" class="text-gray-400 hover:text-red-500 transition" title="Delete Bill"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button></form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8 pt-8">
                <div class="flex items-center gap-2 mb-6"><div class="w-1 h-6 bg-black dark:bg-white rounded-full"></div><h2 class="font-bold text-lg text-gray-800 dark:text-white">My Portfolio</h2></div>
                @if($buildings->isEmpty())
                    <div class="bg-gray-50 dark:bg-gray-900 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl p-12 text-center"><h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No properties found</h3><p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Create your first building to start managing.</p></div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($buildings as $building)
                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col overflow-hidden">
                                <div class="bg-gray-900 dark:bg-black text-white p-5 flex justify-between items-start">
                                    <div class="flex items-start gap-3">
                                        <div class="p-2 bg-gray-800 dark:bg-gray-900 rounded text-gray-300"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg></div>
                                        <div><h3 class="font-bold text-lg leading-tight">{{ $building->name }}</h3><span class="text-[10px] text-gray-400 uppercase tracking-widest mt-1 block">{{ $building->floors->count() }} FLOORS</span></div>
                                    </div>
                                    <form action="{{ route('landlord.building.destroy', $building->id) }}" method="POST" onsubmit="return confirm('Delete this building?');">@csrf @method('DELETE')<button class="text-gray-600 dark:text-gray-400 hover:text-red-400 transition transform hover:scale-110"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button></form>
                                </div>
                                
                                @php
                                    $totalRooms = $building->floors->sum('offices');
                                    $occupiedRooms = $building->tenants->count();
                                    $percent = $totalRooms > 0 ? ($occupiedRooms / $totalRooms) * 100 : 0;
                                @endphp
                                <div class="px-5 pt-4 pb-2">
                                    <div class="flex justify-between text-xs font-bold mb-1.5"><span class="text-gray-400 uppercase tracking-wider text-[10px]">Occupancy</span><span class="{{ $percent == 100 ? 'text-green-600 dark:text-green-400' : 'text-blue-600 dark:text-blue-400' }}">{{ round($percent) }}%</span></div>
                                    <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-1.5"><div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-1.5 rounded-full transition-all duration-1000" style="width: {{ $percent }}%"></div></div>
                                </div>

                                <div x-data="{ expanded: false }" class="bg-white dark:bg-gray-800 flex-grow mt-2">
                                    <button @click="expanded = !expanded" class="w-full py-3 text-xs text-gray-500 dark:text-gray-400 font-bold hover:bg-gray-50 dark:hover:bg-gray-700 transition flex items-center justify-center border-t border-gray-100 dark:border-gray-700 group">
                                        <span x-text="expanded ? 'HIDE ROOMS' : 'VIEW LAYOUT'" class="group-hover:text-gray-800 dark:group-hover:text-white"></span>
                                        <svg x-show="!expanded" class="w-3 h-3 ml-1 group-hover:text-gray-800 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        <svg x-show="expanded" class="w-3 h-3 ml-1 group-hover:text-gray-800 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    </button>
                                    
                                    <div x-show="expanded" class="border-t border-gray-100 dark:border-gray-700 max-h-72 overflow-y-auto bg-gray-50/50 dark:bg-gray-900/50">
                                        @foreach($building->floors as $floor)
                                            <div class="p-3 border-b border-gray-100 dark:border-gray-700 {{ $floor->type == 'residential' ? 'bg-orange-50/40 dark:bg-orange-900/10' : 'bg-white dark:bg-gray-800' }}">
                                                <div class="flex items-center justify-between mb-3">
                                                    <div class="flex items-center">
                                                        <span class="text-[10px] font-bold bg-gray-800 dark:bg-black text-white px-2 py-0.5 rounded shadow-sm">FLOOR {{ $floor->floor_number }}</span>
                                                        @if($floor->type == 'residential')
                                                            <span class="ml-2 text-[10px] text-orange-700 dark:text-orange-300 bg-orange-100 dark:bg-orange-900/40 px-2 py-0.5 rounded-full font-bold flex items-center border border-orange-200 dark:border-orange-800"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>Residential</span>
                                                        @else
                                                            <span class="ml-2 text-[10px] text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900/40 px-2 py-0.5 rounded-full font-bold flex items-center border border-blue-100 dark:border-blue-800"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>Corporate</span>
                                                        @endif
                                                    </div>
                                                    <span class="text-[10px] text-gray-400 font-medium">{{ $floor->offices }} {{ $floor->type == 'residential' ? 'Units' : 'Offices' }}</span>
                                                </div>
                                                
                                                <div class="grid grid-cols-2 gap-2">
                                                    @for($i = 1; $i <= $floor->offices; $i++)
                                                        @php
                                                            $occupant = $building->tenants->first(function($tenant) use ($floor, $i) {
                                                                $tFloors = array_map('trim', explode(',', $tenant->floor_number)); 
                                                                $tRooms = array_map('trim', explode(',', $tenant->room_number));
                                                                
                                                                // Normalize floor comparison (remove 'Floor ' prefix if present)
                                                                $currentFloorName = strtolower(trim(str_replace('Floor ', '', $floor->floor_number)));

                                                                foreach($tFloors as $index => $tFloor) {
                                                                    // Normalize assigned floor
                                                                    $assignedFloorName = strtolower(trim(str_replace('Floor ', '', $tFloor)));
                                                                    
                                                                    if($assignedFloorName == $currentFloorName) {
                                                                        // Check room number match
                                                                        if(isset($tRooms[$index])) {
                                                                            if(trim($tRooms[$index]) == (string)$i) return true;
                                                                        } 
                                                                        // EDGE CASE FIX: If floor has exactly 1 office, assume it's Room 1 if the user didn't specify room.
                                                                        elseif($floor->offices == 1 && $i == 1) {
                                                                            return true;
                                                                        }
                                                                    }
                                                                }
                                                                return false;
                                                            });
                                                        @endphp

                                                        @if($occupant)
                                                            <div class="bg-white dark:bg-gray-800 border border-green-200 dark:border-green-800 rounded p-2 flex items-center shadow-sm relative overflow-hidden">
                                                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-green-500"></div>
                                                                <div class="w-6 h-6 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 flex items-center justify-center mr-2 text-[10px]"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></div>
                                                                <div class="overflow-hidden">
                                                                    <div class="text-[10px] font-bold text-gray-900 dark:text-white truncate">{{ $floor->type == 'residential' ? 'Rm' : 'Off' }} {{ $i }}</div>
                                                                    <div class="text-[9px] text-green-700 dark:text-green-400 truncate font-semibold">{{ $occupant->name }}</div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="border border-dashed border-gray-300 dark:border-gray-600 rounded p-2 flex items-center bg-gray-50 dark:bg-gray-900 opacity-60">
                                                                <div class="w-6 h-6 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-400 flex items-center justify-center mr-2 text-[10px]"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg></div>
                                                                <div>
                                                                    <div class="text-[10px] font-bold text-gray-500 dark:text-gray-400">{{ $floor->type == 'residential' ? 'Rm' : 'Off' }} {{ $i }}</div>
                                                                    <div class="text-[9px] text-gray-400 italic">Vacant</div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>

    @php
        // Prepare Buildings Data for JS
        $buildingsData = $buildings->map(function($b) {
            return [
                'id' => $b->id,
                'name' => $b->name,
                'floors' => $b->floors->map(function($f) {
                    return [
                        'name' => $f->floor_number,
                        'type' => $f->type,
                        'total_rooms' => $f->offices
                    ];
                }),
                'tenants' => $b->tenants->map(function($t) {
                    return [
                        'floor' => (string)$t->floor_number,
                        'room' => (string)$t->room_number
                    ];
                })
            ];
        });

        // Prepare Tenants Data for Detail Modal
        $tenantsData = $tenants->map(function($t) {
            // Defensive coding: Check if bills relation exists or is null
            $bills = $t->bills ?? collect(); 

            return [
                'id' => $t->id,
                'initial' => substr($t->name, 0, 1),
                'name' => $t->name,
                'email' => $t->email,
                'phone' => $t->phone ?? 'Not Provided',
                'joined' => $t->created_at->format('M d, Y'),
                'building' => $t->building ? $t->building->name : 'Unassigned',
                'room' => $t->room_number ? 'Rm ' . $t->room_number : 'N/A',
                // Use the safe $bills variable
                'total_paid' => number_format($bills->where('status', 'paid')->sum('total')),
                'total_pending' => number_format($bills->where('status', '!=', 'paid')->sum('total'))
            ];
        });
    @endphp

    <script>
        const buildingsData = @json($buildingsData);
        const tenantsData = @json($tenantsData);

        function tenantForm() {
            return {
                open: false,
                selectedBuildingId: '',
                units: [{ floor: '', room: '' }],
                
                get currentBuilding() {
                    return buildingsData.find(b => b.id == this.selectedBuildingId);
                },

                get availableFloors() {
                    return this.currentBuilding ? this.currentBuilding.floors : [];
                },

                getRoomsForFloor(floorName) {
                    if (!this.currentBuilding || !floorName) return [];
                    
                    const floor = this.currentBuilding.floors.find(f => f.name == floorName);
                    if (!floor) return [];

                    let rooms = [];
                    for (let i = 1; i <= floor.total_rooms; i++) {
                        // Check if taken
                        let isTaken = this.currentBuilding.tenants.some(t => 
                            t.floor === String(floorName) && t.room === String(i)
                        );
                        
                        rooms.push({
                            number: i,
                            status: isTaken ? 'Occupied' : 'Vacant',
                            label: (floor.type === 'residential' ? 'Rm ' : 'Off ') + i
                        });
                    }
                    return rooms;
                },

                getFloorLabel(type) {
                    return type === 'residential' ? ' (Apartment)' : ' (Corporate)';
                }
            }
        }

        function tenantManager() {
            return {
                open: false,
                showModal: false,
                selectedTenant: {},

                viewTenant(id) {
                    this.selectedTenant = tenantsData.find(t => t.id === id) || {};
                    this.showModal = true;
                    this.open = false; // Close the dropdown
                }
            }
        }
    </script>
</x-app-layout>