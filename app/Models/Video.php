<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = "video";
    protected $fillable = ["image", "linkyt", "created_at", "updated_at", "status"];
    protected $primarykey = "id";
}
