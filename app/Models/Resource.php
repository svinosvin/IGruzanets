<?php

namespace App\Models;

use App\Exceptions\JsonExceptionResponse;
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

    public function syncManySubResources($subresources){

        $prevSubr = $this->sub_resources()->get()->pluck('id');

        foreach ($prevSubr as $subr_id) {
            $model = SubResource::find($subr_id);
            if($model===null){
                return JsonExceptionResponse::error("Subresource № $subr_id does not exist!" ,406);
            }
            $model->my_resource()->disassociate();
            $model->save();

        }
        if($subresources){
            foreach ($subresources as $subresource_id) {
                $model = SubResource::find($subresource_id);
                if($model===null){
                    return JsonExceptionResponse::error("Subresource № $subresource_id does not exist!" ,406);
                }
                $model->my_resource()->associate($this->id);
                $model->save();
            }
        }
    }


}
