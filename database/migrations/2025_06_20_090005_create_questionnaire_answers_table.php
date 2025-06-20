<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('questionnaire_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('respondent_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('question_option_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questionnaire_answers');
    }
};
