<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurvivorInventory extends Model
{
    use HasFactory;

    protected $table = 'survivor_inventories';

    protected $guarded = ['id'];
}
