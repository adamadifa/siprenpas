<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionnaireAnswer extends Model
{
    protected $fillable = ['respondent_id', 'question_id', 'question_option_id'];
    public function respondent()
    {
        return $this->belongsTo(Respondent::class);
    }
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function option()
    {
        return $this->belongsTo(QuestionOption::class, 'question_option_id');
    }
    use HasFactory;
}
