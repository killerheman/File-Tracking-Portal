<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class FileUser extends Authenticatable
{
    use HasFactory, SoftDeletes, HasRoles, Notifiable;
    protected $guarded = [];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function OfficeDep()
    {
        return $this->belongsTo(OfficeDepartment::class, 'off_dep_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'desigantion_id');
    }

    public function getPicUrlAttribute()
    {
        if (!$this->pic)
            return asset('backend/app-assets/images/portrait/small/avatar-s-11.jpg');
        if (str_starts_with($this->pic, 'upload/')) {
            return asset($this->pic);
        }
        return asset('storage/' . $this->pic);
    }
}
