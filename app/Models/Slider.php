<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = "slider";
    protected $fillable = ["title", "desc", "image", "status"];
    protected $primarykey = "id";
    public $timestamps = false;
}
