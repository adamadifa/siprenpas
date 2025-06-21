<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($questionnaireId)
    {
        $questionnaire = \App\Models\Questionnaire::with(['questions.options'])->findOrFail($questionnaireId);
        return view('questionnaires.questions.index', compact('questionnaire'));
    }

    public function create($questionnaireId)
    {
        $questionnaire = \App\Models\Questionnaire::findOrFail($questionnaireId);
        return view('questionnaires.questions.create', compact('questionnaire'));
    }

    public function store(Request $request, $questionnaireId)
    {
        $request->validate([
            'question' => 'required',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
        ]);
        $question = \App\Models\Question::create([
            'questionnaire_id' => $questionnaireId,
            'question' => $request->question,
        ]);
        foreach ($request->options as $opt) {
            \App\Models\QuestionOption::create([
                'question_id' => $question->id,
                'option_text' => $opt,
            ]);
        }
        return redirect()->route('admin.questionnaires.questions.index', $questionnaireId)
            ->with('success','Pertanyaan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($questionnaireId, $id)
    {
        $questionnaire = \App\Models\Questionnaire::findOrFail($questionnaireId);
        $question = \App\Models\Question::with('options')->findOrFail($id);
        return view('questionnaires.questions.edit', compact('questionnaire', 'question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $questionnaireId, $id)
    {
        $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
        ]);
        $question = \App\Models\Question::findOrFail($id);
        $question->question = $request->question;
        $question->save();
        // Hapus opsi lama, lalu tambah opsi baru
        $question->options()->delete();
        foreach ($request->options as $opt) {
            \App\Models\QuestionOption::create([
                'question_id' => $question->id,
                'option_text' => $opt,
            ]);
        }
        return redirect()->route('admin.questionnaires.questions.index', $questionnaireId)
            ->with('success','Pertanyaan berhasil diupdate!');
    }

    public function destroy($questionnaireId, $id)
    {
        $question = \App\Models\Question::findOrFail($id);
        // Hapus semua opsi terkait
        $question->options()->delete();
        // Hapus pertanyaan
        $question->delete();
        return redirect()->route('admin.questionnaires.questions.index', $questionnaireId)
            ->with('success','Pertanyaan berhasil dihapus!');
    }
}
