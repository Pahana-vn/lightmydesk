<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderdetail extends Model
{
    protected $table = "orderdetail";
    protected $fillable = ["id_product", "quantity", "id_order", "status", "created_at", "updated_at"];
    protected $primarykey = "id";
}
