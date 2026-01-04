<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    public static $dispatch = 'dispatch';
    public static $receive = 'receive';

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function dispatchTos()
    {
        return $this->hasMany(DispatchTo::class, 'letter_id');
    }
    public function dispatch(array $dispatchToIds)
    {

        $this->dispatchTos()->delete();
        foreach ($dispatchToIds as $userId) {
            $this->dispatchTos()->create(['letter_dispatch_user_id' => $userId]);
        }
    }
    public function dispatchUsers()
    {
        return $this->belongsToMany(LetterDispatchUser::class, 'dispatch_tos', 'letter_id', 'letter_dispatch_user_id');
    }

    public function getFileUrlAttribute()
    {
        if (!$this->file)
            return '#';
        return asset('storage/' . $this->file);
    }
}
