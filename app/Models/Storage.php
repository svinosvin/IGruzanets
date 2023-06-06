<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;
    protected $guarded = false;
    protected $table = 'storages';

    public function my_resource(){
        return $this->belongsTo(Resource::class, 'resource_id', 'id');
    }

}
