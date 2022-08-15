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
    protected $hidden = ['translations'] ;

    public function scopeParent($query){
        return $query->whereNull('parent_id') ;

    }
    public function scopeChild($query){
        return $query ->whereNotNull('parent_id');
    }
    public function getActive(){
      return   $this -> is_active == 0 ? 'غير مفعل ' : 'مفعل' ;
    }
    public function _parent(){
        return $this->belongsTo(self::class ,'parent_id');
    }

    public function scopeActive($query){
        return $query->where('is_active',1) ;
    }

    public function childrens(){
        return $this -> hasMany(Self::class,'parent_id');
    }

    public function products()
    {
        return $this -> belongsToMany(Product::class,'product_categories');
    }
}
