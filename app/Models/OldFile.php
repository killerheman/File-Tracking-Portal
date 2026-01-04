<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldFile extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function initiating()
    {
        return $this->belongsTo(Branch::class, 'ini_branch');
    }
    public function sender()
    {
        return $this->belongsTo(Branch::class, 'sender_branch');
    }
    public function departureto()
    {
        return $this->belongsTo(Branch::class, 'departure');
    }

    public function getFileUrlAttribute()
    {
        if (!$this->file)
            return '#';
        if (str_starts_with($this->file, 'upload/')) {
            return asset($this->file);
        }
        return asset('storage/' . $this->file);
    }
}
