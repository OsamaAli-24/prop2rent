<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingFloor extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id', 
        'floor_number', 
        'offices', 
        'washrooms', 
        'faculty'
    ];
}