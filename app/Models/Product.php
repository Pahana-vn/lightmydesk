<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "product";
    protected $fillable = ["name", "keyword", "desc", "content", "discount", "price", "price_old", "image", "image_secondary", "images", "id_cat", "date_create", "date_edit", "status"];
    protected $primarykey = "id";
    public $timestamps = false;
}
