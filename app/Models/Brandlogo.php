<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brandlogo extends Model
{
    protected $table = "brandlogo";
    protected $fillable = ["image", "created_at", "updated_at", "status"];
    protected $primarykey = "id";
}
