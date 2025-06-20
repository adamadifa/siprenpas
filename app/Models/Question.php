<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['questionnaire_id', 'question'];
    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }
    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }
    public function answers()
    {
        return $this->hasMany(QuestionnaireAnswer::class);
    }
    use HasFactory;
}
