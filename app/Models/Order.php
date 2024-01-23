<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "order";
    protected $fillable = ["id_account", "ship", "total", "payment", "shiptime", "note", "status", "created_at", "updated_at"];
    protected $primarykey = "id";
}
