<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unit extends Model
{
    protected $table = 'unit';
    protected $fillable = [
        'unit_name',
        'is_primary',
        'invalid'
    ];

    public static function getListUnit()
    {
        return self::where(['invalid' => 0])->orderBy('id','desc')->get();
    }
}
