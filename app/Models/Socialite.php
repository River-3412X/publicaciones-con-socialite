<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
class Socialite extends Model
{
    use HasFactory;
    public $fillable=[
        "id_users",
        "id_social",
        "nombre_social",
        "nombre",
        "email","avatar"
    ];
    public function User(){
        return $this->belongsTo(User::class,"id_users","id");
    }
}