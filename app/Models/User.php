<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'permission',
        'google_id',
        'avatar',
        'avatar_original'
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

    public static function insertOrUpdateUser($data)
    {
        return self::create($data);
    }
    
    public static function checkLogin($data)
    {
        if(isset($data['email']))
        {
            return  self::where([
                'email' => $data['email'],
                'invalid' => 0
            ])->first();
        }
        
        if(isset($data['id']))
        {
            return  self::where([
                'id' => $data['id'],
                'invalid' => 0
            ])->first();
        }else{
            return  self::where([
                'name' => $data['username'],
                'invalid' => 0
            ])->first();
        }
    }

}
