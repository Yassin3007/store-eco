<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable;

class Category extends Model
{
    use HasFactory;
    use \Astrotomic\Translatable\Translatable ;

    protected $with =['translations'] ;
    protected $translatedAttributes = ['name'] ;

    protected  $fillable = ['parent_id' ,'slug' , 'is_active'] ;

    protected $casts =['is_active' => 'boolean'] ;
}
