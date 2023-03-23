<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $table = 'resources';
    protected $guarded = false;

    public function sub_resources(){
        return $this->hasMany(SubResource::class);
    }

    public function services(){
       return $this->belongsToMany(Service::class, 'service_resources', 'resource_id', 'service_id');
    }

    public function attachUniqueService($ids){
        $attachedIds = $this->services()->whereIn('service_id', $ids)->pluck('service_id');
        $newIds = array_diff( $ids, array(...$attachedIds));
        $this->services()->attach($newIds);
    }

}
