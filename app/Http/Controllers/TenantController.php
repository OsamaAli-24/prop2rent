<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\PaymentReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class TenantController extends Controller
{
    /**
     * Display the Tenant Dashboard
     */
    public function index() 
    {
        $user = Auth::user();
        
        // 1. Fetch Bills
        // FIXED: Changed 'building' to 'tenant.building'
        $bills = Bill::where('tenant_id', $user->id)
                     ->with('tenant.building') 
                     ->latest()
                     ->get();

        // 2. Calculate Total Outstanding
        $outstanding = $bills->whereIn('status', ['unpaid', 'defaulter'])->sum(function($bill) {
            return $bill->rent + 
                   $bill->electricity + 
                   $bill->water + 
                   $bill->gas + 
                   $bill->internet + 
                   $bill->maintenance + 
                   $bill->arrears;
        });

        // 3. Return the View
        return view('dashboard', compact('user', 'bills', 'outstanding'));
    }

    /**
     * Upload Payment Proof
     */
    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        $bill = Bill::where('id', $id)->where('tenant_id', Auth::id())->firstOrFail();

        if ($request->hasFile('payment_proof')) {
            if ($bill->payment_proof) {
                Storage::disk('public')->delete($bill->payment_proof);
            }
            
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $bill->payment_proof = $path;
            $bill->status = 'pending'; 
            $bill->save();

            return back()->with('success', 'Proof uploaded successfully! Status is now Pending Verification.');
        }

        return back()->with('error', 'Upload failed. Please try again.');
    }

    /**
     * Download Invoice
     */
    public function downloadInvoice($id)
    {
        // FIXED: Changed 'building' to 'tenant.building' here as well
        $bill = Bill::with('tenant.building')->where('id', $id)->where('tenant_id', Auth::id())->firstOrFail();
        
        $pdf = Pdf::loadView('pdf.invoice', compact('bill'));
        return $pdf->download('Invoice-'.$bill->month.'.pdf');
    }

    public function submitReview(Request $request) 
    {
        // ... (Logic for review if you use it)
    }
}