<?php

namespace App\Models;

use App\Http\Controllers\PendaftaranonlineController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;

class Pendaftaranonline extends Model
{
    use HasFactory;
    protected $table = "pendaftaran_online";
    protected $primaryKey = "no_register";
    protected $guarded = [];
    public $incrementing = false;
}
