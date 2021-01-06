<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Socialite;
use App\Notifications\ResetPassword;

use App\Models\Question;
use App\Models\Commentary;
use App\Models\SubCommentary;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function Socialite(){
        return $this->hasOne(Socialite::class,"id_users","id");
    }
       /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
    public function Question_like(){
        return $this->belongsToMany(Question::class);
    }
    public function Question_dislike(){
        return $this->belongsToMany(Question::class,"question_user_dislike");
    }

    public function Commentary_like(){
        return $this->belongsToMany(Commentary::class);
    }
    public function Commentary_dislike(){
        return $this->belongsToMany(Commentary::class,"commentary_user_dislike");
    }

    public function Sub_commentary_like(){
        return $this->belongsToMany(SubCommentary::class);
    }
    public function Sub_commentary_dislike(){
        return $this->belongsToMany(SubCommentary::class,"sub_commentary_user_dislike");
    }    
}

