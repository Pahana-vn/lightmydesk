<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = "blog";
    protected $fillable = ["title", "name", "info", "image", "avatar", "nameblogger", "descshort", "content", "note", "descproduct", "status", "created_at", "updated_at"];
    protected $primarykey = "id";
}
