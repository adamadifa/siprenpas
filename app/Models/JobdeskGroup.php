<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobdeskGroup extends Model
{
    use HasFactory;

    protected $table = 'jobdesk_group';
    protected $guarded = [];
    protected $primaryKey = 'kode_jobdesk_group';
    public $incrementing = false;

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kode_unit', 'kode_unit');
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'kode_dept', 'kode_dept');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'kode_jabatan', 'kode_jabatan');
    }

    public function details()
    {
        return $this->hasMany(Jobdesk::class, 'kode_jobdesk_group', 'kode_jobdesk_group');
    }
}
