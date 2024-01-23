<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Account extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'account';
    protected $fillable = ["username", "address", "email", "fullname", "phone", "role", "status"];
    protected $primarykey = "id";
    protected $hiden = [
        "password", "remember_token"
    ];
    public $timestamps = false;
}
