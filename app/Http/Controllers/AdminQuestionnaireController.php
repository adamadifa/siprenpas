<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminQuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questionnaires = \App\Models\Questionnaire::withCount('questions')->get();
        return view('questionnaires.index', compact('questionnaires'));
    }

    public function create()
    {
        return view('questionnaires.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ]);
        \App\Models\Questionnaire::create($request->only('title','description'));
        return redirect()->route('admin.questionnaires.index')->with('success','Kuisioner berhasil ditambahkan!');
    }

    public function show($id)
    {
        // Untuk saat ini redirect ke edit saja
        return redirect()->route('admin.questionnaires.edit', $id);
    }

    public function edit($id)
    {
        $questionnaire = \App\Models\Questionnaire::findOrFail($id);
        return view('questionnaires.edit', compact('questionnaire'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ]);
        $q = \App\Models\Questionnaire::findOrFail($id);
        $q->update($request->only('title','description'));
        return redirect()->route('admin.questionnaires.index')->with('success','Kuisioner berhasil diupdate!');
    }

    public function destroy($id)
    {
        $q = \App\Models\Questionnaire::findOrFail($id);
        $q->delete();
        return redirect()->route('admin.questionnaires.index')->with('success','Kuisioner berhasil dihapus!');
    }

    public function report($id)
    {
        $questionnaire = \App\Models\Questionnaire::with(['questions.options.answers'])->findOrFail($id);
        $reportData = [];
        foreach ($questionnaire->questions as $question) {
            $optionCounts = [];
            foreach ($question->options as $option) {
                $optionCounts[] = [
                    'option' => $option->option_text,
                    'count' => $option->answers->count(),
                ];
            }
            $reportData[] = [
                'question' => $question->question,
                'options' => $optionCounts,
            ];
        }
        return view('questionnaires.report', compact('questionnaire', 'reportData'));
    }
}
