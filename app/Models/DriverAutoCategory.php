<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverAutoCategory extends Model
{
    use HasFactory;
    protected $guarded = false;
    protected $table = 'driver_auto_categories';
}
