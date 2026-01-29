<x-app-layout>
    <div class="py-12 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
            
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <h1 class="text-2xl font-bold text-gray-900">Edit Invoice #{{ $bill->id }}</h1>
                <a href="{{ route('landlord.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Dashboard</a>
            </div>

            <form action="{{ route('landlord.bill.update', $bill->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Billing Month</label>
                        <input type="text" name="month" value="{{ $bill->month }}" class="w-full border-gray-300 rounded-lg text-sm p-2 font-bold" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Due Date</label>
                        <input type="date" name="due_date" value="{{ $bill->due_date ? $bill->due_date->format('Y-m-d') : '' }}" class="w-full border-gray-300 rounded-lg text-sm p-2">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Rent Amount ({{ $bill->currency }})</label>
                        <input type="number" name="rent" value="{{ $bill->rent }}" class="w-full border-gray-300 rounded-lg text-sm p-2 font-bold bg-gray-50" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Status</label>
                        <div class="p-2 bg-gray-100 rounded text-sm text-gray-500 font-bold uppercase">{{ $bill->status }}</div>
                    </div>
                </div>

                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 mb-4">
                    <h3 class="text-xs font-bold text-blue-800 uppercase mb-3">Edit Utility Costs</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <div><label class="text-[10px] uppercase font-bold text-gray-500">Electricity</label><input type="number" name="electricity" value="{{ $bill->electricity }}" class="w-full border-gray-300 rounded text-xs"></div>
                        <div><label class="text-[10px] uppercase font-bold text-gray-500">Water</label><input type="number" name="water" value="{{ $bill->water }}" class="w-full border-gray-300 rounded text-xs"></div>
                        <div><label class="text-[10px] uppercase font-bold text-gray-500">Gas</label><input type="number" name="gas" value="{{ $bill->gas }}" class="w-full border-gray-300 rounded text-xs"></div>
                        <div><label class="text-[10px] uppercase font-bold text-gray-500">Internet</label><input type="number" name="internet" value="{{ $bill->internet }}" class="w-full border-gray-300 rounded text-xs"></div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Maintenance</label>
                        <input type="number" name="maintenance" value="{{ $bill->maintenance }}" class="w-full border-gray-300 rounded-lg text-sm p-2">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-red-400 uppercase mb-1">Arrears</label>
                        <input type="number" name="arrears" value="{{ $bill->arrears }}" class="w-full border-red-200 text-red-600 font-bold rounded-lg text-sm p-2">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Notes</label>
                    <textarea name="notes" rows="3" class="w-full border-gray-300 rounded-lg text-sm p-2">{{ $bill->notes }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition">Update Invoice</button>
                    <a href="{{ route('landlord.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-6 rounded-lg transition">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>