<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    protected $guarded = false;


    public function user(){
        return $this->belongsTo(User::class);
    }
    public function change_publish_review(int $is_published = 0){
        $this->is_published = $is_published;
    }
}
