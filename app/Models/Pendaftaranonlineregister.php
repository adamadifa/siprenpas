<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaranonlineregister extends Model
{
    use HasFactory;
    protected $table = "pendaftaran_online_register";
    protected $primaryKey = 'no_register';
    public $incrementing = false;
    protected $guarded = [];
}
