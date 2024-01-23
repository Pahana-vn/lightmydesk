<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comment";
    protected $fillable = ["name", "desc", "pos", "image", "created_at", "updated_at", "status"];
    protected $primarykey = "id";
}
