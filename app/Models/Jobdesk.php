<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobdesk extends Model
{
    use HasFactory;
    protected $table = 'jobdesk';
    protected $guarded = [];
    protected $primaryKey = 'kode_jobdesk';
    public $incrementing = false;

    public function group()
    {
        return $this->belongsTo(JobdeskGroup::class, 'kode_jobdesk_group', 'kode_jobdesk_group');
    }
}
