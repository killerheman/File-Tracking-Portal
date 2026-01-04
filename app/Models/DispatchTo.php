<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatchTo extends Model
{
    use HasFactory;
    protected $fillable=['letter_id','letter_dispatch_user_id'];
    public $timestamps=false;

    public function letterdispatchuser(){
        return $this->belongsTo(LetterDispatchUser::class,'letter_dispatch_user_id');
    }

    public function letter(){
        return $this->belongsTo(Letter::class,'letter_id');
    }
}
