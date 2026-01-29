<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

   protected $fillable = [
    'tenant_id', 'month', 'due_date', 
    'rent', 'arrears', 'maintenance', 'notes',
    'utilities', 'total', 'currency', 'status', 'payment_proof',
    // Individual Utils
    'electricity', 'electricity_proof',
    'water', 'water_proof',
    'gas', 'gas_proof',
    'internet', 'internet_proof'
];

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }
}