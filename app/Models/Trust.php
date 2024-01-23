<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trust extends Model
{
    protected $table = "trust";
    protected $fillable = ["title", "desc", "image", "status"];
    protected $primarykey = "id";
    public $timestamps = false;
}
