<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $guarded = false;



    public function my_resources(){
       return  $this->belongsToMany(Resource::class, 'service_resources', 'service_id', 'resource_id');
    }
    public function attachUniqueResources($ids){
        $attachedIds = $this->my_resources()->whereIn('resource_id', $ids)->pluck('resource_id');
        $newIds = array_diff( $ids, array(...$attachedIds));
        $this->my_resources()->attach($newIds);

    }
}