<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklistibadah extends Model
{
    use HasFactory;
    protected $table = 'checklist_ibadah';
    protected $primaryKey = 'kode_checklist_ibadah';
    protected $guarded = [];
    public $incrementing = false;
}
