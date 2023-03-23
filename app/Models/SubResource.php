<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubResource extends Model
{
    use HasFactory;

   protected $table = 'sub_resources';
   protected $guarded = false;

   public function my_resource(){
       return $this->belongsTo(Resource::class, 'resource_id', 'id');
   }
    public function attachUniqueResources($ids){
        $attachedIds = $this->my_resources()->whereIn('resource_id', $ids)->pluck('resource_id');
        $newIds = array_diff( $ids, array(...$attachedIds));
        $this->my_resources()->attach($newIds);
    }

}
