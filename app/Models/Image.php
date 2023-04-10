<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    public const FOLDER_BASE = '';
    public const FOLDER_AUTO = 'Auto';

    protected $guarded = false;

    protected $table = 'images';


}
