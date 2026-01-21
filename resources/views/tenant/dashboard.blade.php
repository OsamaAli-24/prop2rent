<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6">My Bills</h1>

        @foreach($bills as $bill)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-4 border-l-8 {{ $bill->status == 'paid' ? 'border-green-500' : ($bill->status == 'defaulter' ? 'border-red-500' : 'border-yellow-500') }}">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold">{{ $bill->month }}</h2>
                    <p class="text-gray-600">Total Due: ${{ $bill->total }}</p>
                </div>
                <div class="text-right">
                    <span class="font-bold uppercase {{ $bill->status == 'paid' ? 'text-green-600' : 'text-red-600' }}">{{ $bill->status }}</span>
                </div>
            </div>

            @if($bill->status !== 'paid')
            <div class="mt-4 pt-4 border-t flex gap-2">
                <button class="bg-green-600 text-white px-4 py-2 rounded">Pay Now</button>
                <form action="{{ route('tenant.review.store') }}" method="POST" class="flex-1 flex gap-2">
                    @csrf
                    <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                    <input type="hidden" name="issue_type" value="check">
                    <input type="text" name="details" placeholder="Report issue..." class="border p-2 rounded w-full">
                    <button class="bg-gray-200 px-4 py-2 rounded">Report</button>
                </form>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</x-app-layout>