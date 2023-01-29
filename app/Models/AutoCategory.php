<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoCategory extends Model
{
    use HasFactory;

    protected $table = 'auto_categories';
    protected $guarded = false;

    public function drivers(){

        return $this->belongsToMany(Driver::class, 'driver_auto_categories','category_id', 'driver_id');
    }
}
