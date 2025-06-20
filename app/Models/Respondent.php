<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respondent extends Model
{
    protected $fillable = ['questionnaire_id', 'name', 'email'];
    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }
    public function answers()
    {
        return $this->hasMany(QuestionnaireAnswer::class);
    }
    use HasFactory;
}
