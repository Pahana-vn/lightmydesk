<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footbanner extends Model
{
    protected $table = "footbanner";
    protected $fillable = ["title", "desc", "image", "status"];
    protected $primarykey = "id";
    public $timestamps = false;
}
