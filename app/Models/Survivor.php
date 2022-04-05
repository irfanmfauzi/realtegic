<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survivor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function SurvivorInventory()
    {
        return $this->hasMany(SurvivorInventory::class);
    }
}
