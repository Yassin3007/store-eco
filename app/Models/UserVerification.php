<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
    use HasFactory;

    public $table = 'users_verificationCodes' ;
    protected $fillable =['user_id' , 'code' ,'created_at' , 'updated_at'] ;

    public function user(){
        return $this->belongsTo(User::class , 'user_id');
    }
}
