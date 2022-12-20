<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    use HasFactory;

    protected $table = 'autos';
    protected $guarded = false;


    public function auto_category(){
        return $this->hasOne(AutoCategory::class);
    }
}
