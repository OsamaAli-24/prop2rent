<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class LandlordController extends Controller
{
    // ==========================================
    // DASHBOARD & STATS
    // ==========================================
    public function dashboard(Request $request)
    {
        // 1. Fetch Data
        $tenants = User::where('role', 'tenant')->get();
        $buildings = Building::with(['floors', 'tenants'])->get();
        $bills = Bill::with('tenant.building')->latest()->get();

        // 2. Handle Currency Filter
        $selectedCurrency = $request->input('currency', 'USD');
        
        $currencySymbol = match($selectedCurrency) {
            'PKR' => '₨',
            'EUR' => '€',
            'GBP' => '£',
            default => '$'
        };

        // 3. Calculate Stats (Filtered by Selected Currency)
        $billsForStats = $bills->where('currency', $selectedCurrency);

        $totalReceived = $billsForStats->where('status', 'paid')->sum('total');
        $totalPending = $billsForStats->where('status', '!=', 'paid')->sum('total');
        
        $totalTenants = $tenants->count();
        $totalBuildings = $buildings->count();

        return view('landlord.dashboard', compact(
            'tenants', 
            'buildings', 
            'bills', 
            'totalReceived', 
            'totalPending', 
            'totalTenants', 
            'totalBuildings',
            'selectedCurrency',
            'currencySymbol'
        ));
    }

    // ==========================================
    // BILLING MANAGEMENT
    // ==========================================
    public function storeBill(Request $request)
    {
        // 1. Validate
        $request->validate([
            'tenant_id' => 'required|exists:users,id',
            'month' => 'required',
            'due_date' => 'nullable|date',
            'rent' => 'required|numeric',
            'electricity_proof' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'water_proof' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'gas_proof' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'internet_proof' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // 2. Calculate Total
        $utilities = ($request->electricity ?? 0) + ($request->water ?? 0) + ($request->gas ?? 0) + ($request->internet ?? 0);
        $total = $request->rent + $utilities + ($request->maintenance ?? 0) + ($request->arrears ?? 0);

        // 3. Handle File Uploads
        $elecPath = $request->file('electricity_proof') ? $request->file('electricity_proof')->store('utility_proofs', 'public') : null;
        $waterPath = $request->file('water_proof') ? $request->file('water_proof')->store('utility_proofs', 'public') : null;
        $gasPath = $request->file('gas_proof') ? $request->file('gas_proof')->store('utility_proofs', 'public') : null;
        $netPath = $request->file('internet_proof') ? $request->file('internet_proof')->store('utility_proofs', 'public') : null;

        // 4. Create Bill
        Bill::create([
            'tenant_id' => $request->tenant_id,
            'month' => $request->month,
            'due_date' => $request->due_date,
            'currency' => $request->currency ?? 'USD',
            
            'rent' => $request->rent,
            'arrears' => $request->arrears ?? 0,
            'maintenance' => $request->maintenance ?? 0,
            'notes' => $request->notes,

            // Utilities & Proofs
            'electricity' => $request->electricity,
            'electricity_proof' => $elecPath, 
            
            'water' => $request->water,
            'water_proof' => $waterPath, 
            
            'gas' => $request->gas,
            'gas_proof' => $gasPath, 
            
            'internet' => $request->internet,
            'internet_proof' => $netPath, 

            'utilities' => $utilities,
            'total' => $total,
            'status' => 'unpaid'
        ]);

        return back()->with('success', 'Bill generated successfully with proofs!');
    }

    // Show Edit Page
    public function editBill($id)
    {
        $bill = Bill::findOrFail($id);
        $tenants = User::where('role', 'tenant')->get();
        return view('landlord.bills.edit', compact('bill', 'tenants'));
    }

    // Handle Update
    public function updateBill(Request $request, $id)
    {
        $bill = Bill::findOrFail($id);

        $request->validate([
            'month' => 'required',
            'rent' => 'required|numeric',
            'due_date' => 'nullable|date',
            'electricity_proof' => 'nullable|image|max:2048',
            'water_proof' => 'nullable|image|max:2048',
            'gas_proof' => 'nullable|image|max:2048',
            'internet_proof' => 'nullable|image|max:2048',
        ]);

        // 1. Update Basic Fields
        $bill->rent = $request->rent;
        $bill->month = $request->month;
        $bill->due_date = $request->due_date;
        $bill->currency = $request->currency;
        $bill->arrears = $request->arrears ?? 0;
        $bill->maintenance = $request->maintenance ?? 0;
        $bill->notes = $request->notes;

        // 2. Update Utility Amounts
        if($request->has('electricity')) $bill->electricity = $request->electricity;
        if($request->has('water')) $bill->water = $request->water;
        if($request->has('gas')) $bill->gas = $request->gas;
        if($request->has('internet')) $bill->internet = $request->internet;

        // 3. Update Utility Proofs
        if ($request->hasFile('electricity_proof')) {
            if($bill->electricity_proof) Storage::disk('public')->delete($bill->electricity_proof);
            $bill->electricity_proof = $request->file('electricity_proof')->store('utility_proofs', 'public');
        }
        if ($request->hasFile('water_proof')) {
            if($bill->water_proof) Storage::disk('public')->delete($bill->water_proof);
            $bill->water_proof = $request->file('water_proof')->store('utility_proofs', 'public');
        }
        if ($request->hasFile('gas_proof')) {
            if($bill->gas_proof) Storage::disk('public')->delete($bill->gas_proof);
            $bill->gas_proof = $request->file('gas_proof')->store('utility_proofs', 'public');
        }
        if ($request->hasFile('internet_proof')) {
            if($bill->internet_proof) Storage::disk('public')->delete($bill->internet_proof);
            $bill->internet_proof = $request->file('internet_proof')->store('utility_proofs', 'public');
        }

        // 4. Recalculate Totals
        $bill->utilities = ($bill->electricity ?? 0) + ($bill->water ?? 0) + ($bill->gas ?? 0) + ($bill->internet ?? 0);
        $bill->total = $bill->rent + $bill->utilities + $bill->maintenance + $bill->arrears;

        $bill->save();

        return redirect()->route('landlord.dashboard')->with('success', 'Invoice updated successfully!');
    }

    public function updateBillStatus(Request $request, $id) 
    {
        $bill = Bill::findOrFail($id);
        $bill->status = $request->status;
        $bill->save();
        return back()->with('success', 'Status Updated');
    }

    public function destroyBill($id)
    {
        $bill = Bill::findOrFail($id);
        if($bill->payment_proof) Storage::disk('public')->delete($bill->payment_proof);
        
        $bill->delete();
        return back()->with('success', 'Invoice deleted successfully.');
    }

    public function downloadProof($id)
    {
        $bill = Bill::findOrFail($id);
        if (!$bill->payment_proof) return back()->with('error', 'No proof uploaded for this bill.');

        $pdf = Pdf::loadView('pdf.proof', compact('bill'));
        return $pdf->download('proof_bill_' . $bill->id . '.pdf');
    }

    // ==========================================
    // BUILDING MANAGEMENT
    // ==========================================
    public function storeBuilding(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'floors' => 'required|array',
            'floors.*.name' => 'required|string',
            'floors.*.type' => 'required|string',
        ]);

        $building = Building::create([
            'name' => $request->name,
            'user_id' => Auth::id(), 
        ]);

        foreach ($request->floors as $floorData) {
            $building->floors()->create([
                'floor_number' => $floorData['name'],
                'type' => $floorData['type'],
                'offices' => $floorData['offices'] ?? 0,
                'washrooms' => $floorData['washrooms'] ?? 0,
                'faculty' => $floorData['faculty'] ?? 0,
            ]);
        }
        
        return back()->with('success', 'Building created successfully!');
    }

    public function destroyBuilding($id)
    {
        $building = Building::where('id', $id)->firstOrFail();
        $building->delete();
        return back()->with('success', 'Building deleted successfully.');
    }

    // ==========================================
    // TENANT MANAGEMENT (UPDATED WITH PHONE)
    // ==========================================
    public function storeTenant(Request $request)
    {
        // 1. Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20', // <--- ADDED PHONE VALIDATION
            'password' => 'required|string|min:8',
            'building_id' => 'required|exists:buildings,id',
            'units' => 'required|array',
            'units.*.floor' => 'required|string',
            'units.*.room' => 'nullable|string',
        ]);

        // 2. Occupancy Check
        $buildingId = $request->building_id;
        $existingTenants = User::where('role', 'tenant')->where('building_id', $buildingId)->get();

        foreach ($request->units as $newUnit) {
            $newFloor = trim($newUnit['floor']);
            $newRoom = trim($newUnit['room']);

            foreach ($existingTenants as $tenant) {
                $tFloors = array_map('trim', explode(',', $tenant->floor_number));
                $tRooms = array_map('trim', explode(',', $tenant->room_number));

                foreach ($tFloors as $index => $tFloor) {
                    $tRoom = $tRooms[$index] ?? ''; 
                    // Check Match
                    if (strcasecmp($tFloor, $newFloor) == 0 && strcasecmp($tRoom, $newRoom) == 0) {
                        return back()->withInput()->with('error', "Occupancy Error: Room '$newRoom' on Floor '$newFloor' is already occupied by " . $tenant->name . ".");
                    }
                }
            }
        }

        // 3. Save Tenant
        $floors = collect($request->units)->pluck('floor')->implode(', ');
        $rooms = collect($request->units)->pluck('room')->implode(', ');

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone, // <--- SAVING PHONE NUMBER
            'password' => Hash::make($request->password),
            'role' => 'tenant',
            'building_id' => $request->building_id,
            'floor_number' => $floors,
            'room_number' => $rooms,
        ]);

        return back()->with('success', 'Tenant registered successfully!');
    }

    public function destroyTenant($id)
    {
        $tenant = User::findOrFail($id);
        if($tenant->role !== 'tenant') return back()->with('error', 'You can only delete tenants.');

        $tenant->delete();
        return back()->with('success', 'Tenant removed successfully.');
    }

    // ==========================================
    // SETTINGS & PROFILE
    // ==========================================
    public function settings()
    {
        return view('landlord.settings', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePreferences(Request $request)
    {
        $user = Auth::user();
        $request->validate(['theme' => 'required|in:light,dark', 'language' => 'required|in:en,ur,es']);
        
        $user->update([
            'theme' => $request->theme,
            'language' => $request->language,
        ]);

        return back()->with('success', 'Preferences saved!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed',
        ]);

        Auth::user()->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully.');
    }
}