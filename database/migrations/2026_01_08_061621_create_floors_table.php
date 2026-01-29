<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('floors', function (Blueprint $table) {
        $table->id();
        $table->foreignId('building_id')->constrained('buildings')->onDelete('cascade');
        $table->string('floor_number');
        
        // This column stores 'office' or 'apartment'
        $table->string('type')->default('office'); 
        
        // These numbers will mean different things based on the type
        $table->integer('offices')->default(0); 
        $table->integer('washrooms')->default(0);
        $table->integer('faculty')->default(0);
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('floors');
    }
};
