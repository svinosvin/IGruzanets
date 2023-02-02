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
        return $this->belongsToMany(SubResource::class, 'resource_sub_resources', 'resource_id', 'sub_resource_id');
    }

    public function services(){
       return $this->belongsToMany(Service::class, 'service_resources', 'resource_id', 'service_id');
    }

    public function attachUniqueSubResource($ids){
        $attachedIds = $this->sub_resources()->whereIn('sub_resource_id', $ids)->pluck('sub_resource_id');
        $newIds = array_diff( $ids, array(...$attachedIds));
        $this->sub_resources()->attach($newIds);
    }

    public function attachUniqueService($ids){
        $attachedIds = $this->services()->whereIn('service_id', $ids)->pluck('service_id');
        $newIds = array_diff( $ids, array(...$attachedIds));
        $this->services()->attach($newIds);
    }

}
