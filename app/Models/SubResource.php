<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubResource extends Model
{
    use HasFactory;

   protected $table = 'sub_resources';
   protected $guarded = false;

   public function my_resources(){
       return $this->belongsToMany(Resource::class, 'resource_sub_resources', 'sub_resource_id', 'resource_id');
   }
    public function attachUniqueResources($ids){
        $attachedIds = $this->my_resources()->whereIn('resource_id', $ids)->pluck('resource_id');
        $newIds = array_diff( $ids, array(...$attachedIds));
        $this->my_resources()->attach($newIds);
    }

}
