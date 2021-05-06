<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $table = 'category';
    protected $fillable = [
        'category_name',
        'status',
        'invalid'
    ];

    public static function getListCategory()
    {
        return self::where(['invalid' => 0])->orderBy('id','desc')->get();
    }

    public static function insertOrUpdateCategory($data,$id = null)
    {
        if(isset($data['category_name']))
        {
            $check = self::checkNameCategory($data['category_name']);
            if(!is_null($check))
            {
                return 'existscategory';
            }
        }

        if(is_null($id))
        {
            $result = self::create($data);
        }else{
            $result = self::where([
                'id' => $id,
                'invalid' => 0
            ])->update($data);
        }

        return 'success';
    }

    public static function checkNameCategory($name)
    {
        return self::where([
            'category_name' => $name,
            'invalid' => 0
        ])->first();
    }

    public static function deleteCategory($id)
    {
        $result = self::where(['id' => $id,'invalid' => 0])->update(['invalid' => 1]);
        if($result)
        {
            return 'success';
        }
    }
}
