<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->foreign('questionnaire_id')->references('id')->on('questionnaires')->onDelete('cascade');
        });
        Schema::table('question_options', function (Blueprint $table) {
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
        Schema::table('respondents', function (Blueprint $table) {
            $table->foreign('questionnaire_id')->references('id')->on('questionnaires')->onDelete('cascade');
        });
        Schema::table('questionnaire_answers', function (Blueprint $table) {
            $table->foreign('respondent_id')->references('id')->on('respondents')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('question_option_id')->references('id')->on('question_options')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['questionnaire_id']);
        });
        Schema::table('question_options', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
        });
        Schema::table('respondents', function (Blueprint $table) {
            $table->dropForeign(['questionnaire_id']);
        });
        Schema::table('questionnaire_answers', function (Blueprint $table) {
            $table->dropForeign(['respondent_id']);
            $table->dropForeign(['question_id']);
            $table->dropForeign(['question_option_id']);
        });
    }
};
