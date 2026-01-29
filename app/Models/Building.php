<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    // Allow these columns to be saved
    protected $fillable = ['name', 'user_id'];

    /**
     * Relationship: A Building has many Floors.
     */
    public function floors()
    {
        return $this->hasMany(Floor::class);
    }

    /**
     * Relationship: A Building has many Tenants (Users).
     */
    public function tenants()
    {
        return $this->hasMany(User::class);
    }
}