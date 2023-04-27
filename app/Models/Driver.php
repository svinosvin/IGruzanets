<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'drivers';
    protected $guarded = false;

    public function auto_categories(){

        return $this->belongsToMany(AutoCategory::class, 'driver_auto_categories', 'driver_id', 'category_id');
    }

    public function attachUniqueCategories($ids){
        $attachedIds = $this->auto_categories()->whereIn('category_id', $ids)->pluck('category_id');
        $newIds = array_diff( $ids, array(...$attachedIds));
        $this->auto_categories()->attach($newIds);
    }


    public function getImgUrlAttribute(){
        if($this->img === null){
            return null;
        }
        return url('storage/'. $this->img);
    }
}
