<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogdetail extends Model
{
    protected $table = "blogdetail";
    protected $fillable = ["image", "avatar", "name", "motangan", "cont", "note", "motasanpham", "id_blog",  "created_at", "updated_at",];
    protected $primarykey = "id";
}
