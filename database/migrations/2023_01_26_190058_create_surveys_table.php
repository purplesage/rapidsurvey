<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('surveys', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->boolean('is_active');
      $table->string('description');
      $table->string('thumbnail')->nullable();
      $table->date('expire_date');
      $table->json('questionList');
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('surveys');
  }
};
