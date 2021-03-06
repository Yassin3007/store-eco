<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Brand extends Model
{
    use HasFactory;
    use Translatable;
    protected $with =['translations'] ;

    protected $fillable = ['is_active','photo'] ;

    protected $casts = [
        'is_active' =>'boolean'
    ];

    public $translatedAttributes =['name'] ;

    public function getActive(){
        return $this->is_active==0 ? 'غير مفعل' : 'مفعل' ;
    }

    public function getPhotoAttribute($val){
        return ( $val!== null)? asset('assets/images/brands/'.$val):'' ;
    }

    public function scopeActive($query){
        return $query->where('is_active',1);
    }
}
