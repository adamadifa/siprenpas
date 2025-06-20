<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    protected $fillable = ['title', 'description'];
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function respondents()
    {
        return $this->hasMany(Respondent::class);
    }
    use HasFactory;
}
