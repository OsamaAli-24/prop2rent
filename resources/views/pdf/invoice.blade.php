<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $bill->id }}</title>
    <style>
        body { font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; text-align: center; color: #777; }
        body h1 { font-weight: 300; margin-bottom: 0px; padding-bottom: 0px; color: #000; }
        body h3 { font-weight: 300; margin-top: 10px; margin-bottom: 20px; font-style: italic; color: #555; }
        body a { color: #06f; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 16px; line-height: 24px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #555; text-align: left; }
        .invoice-box table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        .invoice-box table td { padding: 5px; vertical-align: top; }
        .invoice-box table tr td:nth-child(2) { text-align: right; }
        .invoice-box table tr.top table td { padding-bottom: 20px; }
        .invoice-box table tr.top table td.title { font-size: 45px; line-height: 45px; color: #333; }
        .invoice-box table tr.information table td { padding-bottom: 40px; }
        .invoice-box table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
        .invoice-box table tr.details td { padding-bottom: 20px; }
        .invoice-box table tr.item td { border-bottom: 1px solid #eee; }
        .invoice-box table tr.item.last td { border-bottom: none; }
        .invoice-box table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; font-size: 18px; }
        .badge { padding: 5px 10px; color: white; border-radius: 5px; font-size: 12px; font-weight: bold; }
        .bg-green { background-color: #2ecc71; }
        .bg-red { background-color: #e74c3c; }
        .bg-yellow { background-color: #f1c40f; color: #333; }
        
        /* Image Style */
        .proof-section { margin-top: 30px; text-align: center; border-top: 2px dashed #eee; padding-top: 20px; }
        .proof-img { max-width: 300px; max-height: 400px; border: 1px solid #ddd; padding: 5px; border-radius: 4px; }
        .error-msg { color: red; font-size: 10px; }
    </style>
</head>
<body>
    @php 
        $sym = '$'; 
        if($bill->currency == 'PKR') $sym = 'Rs '; 
        if($bill->currency == 'EUR') $sym = '€'; 
        if($bill->currency == 'GBP') $sym = '£'; 
    @endphp

    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                BMS<span style="color:#666; font-size:20px;">App</span>
                            </td>
                            <td>
                                <strong>Invoice #:</strong> {{ $bill->id }}<br>
                                <strong>Month:</strong> {{ $bill->month }}<br>
                                <strong>Due Date:</strong> {{ $bill->due_date ?? 'Immediate' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>Landlord / Management</strong><br>
                                Islamabad Capital Territory<br>
                                Pakistan
                            </td>
                            <td>
                                <strong>Bill To:</strong><br>
                                {{ $bill->tenant->name }}<br>
                                {{ $bill->tenant->email }}<br>
                                @if($bill->tenant->building)
                                    {{ $bill->tenant->building->name }}, Room {{ $bill->tenant->room_number ?? 'N/A' }}
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Description</td>
                <td>Amount</td>
            </tr>

            <tr class="item">
                <td>Base Rent</td>
                <td>{{ $sym }}{{ number_format($bill->rent) }}</td>
            </tr>

            @if($bill->maintenance > 0)
            <tr class="item">
                <td>Maintenance Charges</td>
                <td>{{ $sym }}{{ number_format($bill->maintenance) }}</td>
            </tr>
            @endif

            @if($bill->electricity > 0)
            <tr class="item">
                <td>Electricity Bill</td>
                <td>{{ $sym }}{{ number_format($bill->electricity) }}</td>
            </tr>
            @endif

            @if($bill->water > 0)
            <tr class="item">
                <td>Water Bill</td>
                <td>{{ $sym }}{{ number_format($bill->water) }}</td>
            </tr>
            @endif

            @if($bill->gas > 0)
            <tr class="item">
                <td>Gas Bill</td>
                <td>{{ $sym }}{{ number_format($bill->gas) }}</td>
            </tr>
            @endif

            @if($bill->internet > 0)
            <tr class="item">
                <td>Internet / Wi-Fi</td>
                <td>{{ $sym }}{{ number_format($bill->internet) }}</td>
            </tr>
            @endif

            @if($bill->arrears > 0)
            <tr class="item" style="color: #e74c3c;">
                <td>Arrears (Previous Debt)</td>
                <td>{{ $sym }}{{ number_format($bill->arrears) }}</td>
            </tr>
            @endif

            <tr class="total">
                <td>
                    <br>Status: 
                    @if($bill->status == 'paid') <span class="badge bg-green">PAID</span>
                    @elseif($bill->status == 'unpaid') <span class="badge bg-yellow">UNPAID</span>
                    @else <span class="badge bg-red">DEFAULTER</span> @endif
                </td>
                <td><br>Total: {{ $sym }}{{ number_format($bill->total) }}</td>
            </tr>
        </table>
        
        <br>
        @if($bill->notes)
            <p style="font-size: 12px; font-style: italic; color: #888;"><strong>Note:</strong> {{ $bill->notes }}</p>
        @endif

        @if($bill->payment_proof)
            <div class="proof-section">
                <h4 style="margin-bottom: 10px; color: #555; text-transform: uppercase; font-size: 12px;">Attached Proof of Payment</h4>
                
    @php
    // Get just the filename (in case database has "receipts/image.jpg")
    $filename = basename($bill->payment_proof);

    // List of places to look for the file on the hard drive
    $paths_to_check = [
        base_path('storage/app/public/receipts/' . $filename),
        base_path('storage/app/public/payment_proofs/' . $filename),
        storage_path('app/public/receipts/' . $filename),
        public_path('storage/receipts/' . $filename)
    ];

    $src = '';
    foreach ($paths_to_check as $path) {
        if (file_exists($path)) {
            // Encode image to Base64
            $imageData = base64_encode(file_get_contents($path));
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $src = 'data:image/' . $extension . ';base64,' . $imageData;
            break;
        }
    }
@endphp

@if($src)
    <div class="proof-section">
        <h4>Attached Proof of Payment</h4>
        <img src="{{ $src }}" class="proof-img" style="max-width:300px;">
    </div>
@else
    <p style="color:red; font-size:10px;">
        Image not found.<br>
        Looking for: {{ $filename }}<br>
        Inside: storage/app/public/receipts/
    </p>
@endif
            </div>
        @endif
        <p style="text-align: center; font-size: 12px; margin-top: 30px;">Thank you for your timely payment.</p>
    </div>
</body>
</html>