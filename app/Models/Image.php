<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    public const FOLDER_BASE = '';
    public const FOLDER_AUTO = 'Auto';
    public const FOLDER_SERVICE = 'Service';
    public const FOLDER_DRIVER = 'Driver';

    protected $guarded = false;

    protected $table = 'images';


}
