<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentFile extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(FileType::class,'file_type_id');
    }
    public function mode()
    {
        return $this->belongsTo(FileMode::class,'file_mode_id');

    }
    public function filestatus()
    {
        return $this->belongsTo(FileStatus::class,'status');
    }
    public function created_by_user()
    {
        return $this->belongsTo(FileUser::class,'created_by');
    }

    public function current_location()
    {
        return $this->belongsTo(Fileuser::class,'current_user');
    }

    public function transfer_by()
    {
        return $this->belongsTo(FileUser::class,'transfer_by');
    }
    public function tracking()
    {
        return $this->hasMany(FileTracking::class,'file_id');
    }
    public function FileTypeMain()
    {
        return $this->belongsTo(OfficeDepartment::class,'file_type_main_id');
    }
}
