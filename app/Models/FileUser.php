<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class FileUser extends Authenticatable
{
    use HasFactory, SoftDeletes, HasRoles;
    protected $guarded = [];

    public function getFullNameAttribute()
    {
        return $this->first_name. ' '. $this->last_name;
    }
}
