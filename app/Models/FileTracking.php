<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileTracking extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(FileType::class,'file_type_id');
    }
    public function mode()
    {
        return $this->belongsTo(FileMode::class,'mode_id');

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
}
