<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            
            // Basic Info
            $table->string('month'); // e.g., "Jan 2026"
            $table->date('due_date')->nullable();
            $table->string('currency')->default('USD');
            
            // Financials (The error happened here, we fix it by naming it 'rent')
            $table->integer('rent'); 
            $table->integer('arrears')->default(0);
            $table->integer('maintenance')->default(0);
            
            // Utilities Breakdown
            $table->integer('electricity')->nullable();
            $table->string('electricity_proof')->nullable(); // File path
            
            $table->integer('water')->nullable();
            $table->string('water_proof')->nullable(); // File path
            
            $table->integer('gas')->nullable();
            $table->string('gas_proof')->nullable(); // File path
            
            $table->integer('internet')->nullable();
            $table->string('internet_proof')->nullable(); // File path
            
            // Totals & Status
            $table->integer('utilities')->default(0); // Sum of all utilities
            $table->integer('total'); // Grand total
            $table->string('status')->default('unpaid'); // unpaid, paid, defaulter
            
            // Proof of Payment (from Tenant)
            $table->string('payment_proof')->nullable();
            
            // Remarks
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};