<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicQuestionnaireController extends Controller
{
    public function list()
    {
        $questionnaires = \App\Models\Questionnaire::all();
        return view('questionnaires.public.list', compact('questionnaires'));
    }

    public function index($id)
    {
        $questionnaire = \App\Models\Questionnaire::with(['questions.options'])->findOrFail($id);
        return view('questionnaires.public.form', compact('questionnaire'));
    }

    public function store(Request $request, $id)
    {
        $questionnaire = \App\Models\Questionnaire::with('questions')->findOrFail($id);
        // Simpan data responden
        $respondent = \App\Models\Respondent::create([
            'questionnaire_id' => $id,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
        // Simpan jawaban untuk setiap pertanyaan
        foreach ($questionnaire->questions as $question) {
            $optionId = $request->input('answers.' . $question->id);
            if ($optionId) {
                \App\Models\QuestionnaireAnswer::create([
                    'respondent_id' => $respondent->id,
                    'question_id' => $question->id,
                    'question_option_id' => $optionId,
                ]);
            }
        }
        return view('questionnaires.public.success');
    }
}
