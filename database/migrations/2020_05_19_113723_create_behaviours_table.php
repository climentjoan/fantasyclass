<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBehavioursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('behaviours', function (Blueprint $table) {
            $table->id();
            $table->string('icon', 50);
            $table->string('name', 200);
            $table->string('custom_text', 255)->nullable();
            $table->integer('hp')->default(0);
            $table->integer('xp')->default(0);
            $table->integer('gems')->default(0);
            $table->integer('gold')->default(0);
            $table->unsignedBigInteger('classroom_id')->nullable();
            $table->integer('count_number')->default(0);
            $table->timestamps();
        });

        DB::table('behaviours')->insert(
            [
                ['id' => '1', 'name' => 'hp_participation', 'icon' => 'far fa-hand-point-up', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'gems' => '0', 'custom_text' => 'hp_participation', 'classroom_id' => NULL],
                ['id' => '2', 'name' => 'hp_homework', 'icon' => 'fas fa-book-open', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'gems' => '0', 'custom_text' => 'hp_homework', 'classroom_id' => NULL],
                ['id' => '3', 'name' => 'hp_behaviour', 'icon' => 'far fa-smile', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'gems' => '0', 'custom_text' => 'hp_behaviour', 'classroom_id' => NULL],
                ['id' => '4', 'name' => 'hp_task_effort', 'icon' => 'far fa-hand-rock', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'gems' => '0', 'custom_text' => 'hp_task_effort', 'classroom_id' => NULL],
                ['id' => '5', 'name' => 'hp_attendance', 'icon' => 'far fa-clock', 'hp' => '10', 'xp' => '0', 'gold' => '0', 'gems' => '0', 'custom_text' => 'hp_attendance', 'classroom_id' => NULL],
                ['id' => '6', 'name' => 'hp_team_work', 'icon' => 'fas fa-users', 'hp' => '5', 'xp' => '0', 'gold' => '0', 'gems' => '0', 'custom_text' => 'hp_team_work', 'classroom_id' => NULL],
                ['id' => '7', 'name' => 'hp_answer_ok', 'icon' => 'far fa-thumbs-up', 'hp' => '5', 'xp' => '20', 'gold' => '0', 'gems' => '0', 'custom_text' => 'hp_answer_ok', 'classroom_id' => NULL],
                ['id' => '10', 'name' => 'hp_mobile', 'icon' => 'fas fa-mobile-alt', 'hp' => '-20', 'xp' => '0', 'gold' => '0', 'gems' => '0', 'custom_text' => 'hp_mobile', 'classroom_id' => NULL],
                ['id' => '11', 'name' => 'hp_no_homework', 'icon' => 'fas fa-book-open', 'hp' => '-20', 'xp' => '0', 'gold' => '0', 'gems' => '0', 'custom_text' => 'hp_no_homework', 'classroom_id' => NULL],
                ['id' => '12', 'name' => 'hp_bad_behaviour', 'icon' => 'far fa-angry', 'hp' => '-40', 'xp' => '0', 'gold' => '0', 'gems' => '0', 'custom_text' => 'hp_bad_behaviour', 'classroom_id' => NULL],
                ['id' => '13', 'name' => 'hp_no_subject', 'icon' => 'fas fa-gamepad', 'hp' => '-20', 'xp' => '0', 'gold' => '0', 'gems' => '0', 'custom_text' => 'hp_no_subject', 'classroom_id' => NULL],
                ['id' => '14', 'name' => 'hp_late', 'icon' => 'far fa-clock', 'hp' => '-5', 'xp' => '0', 'gold' => '0', 'gems' => '0', 'custom_text' => 'hp_late', 'classroom_id' => NULL],
                ['id' => '15', 'name' => 'hp_attendance_down', 'icon' => 'far fa-calendar-alt', 'hp' => '-15', 'xp' => '0', 'gold' => '0', 'gems' => '0', 'custom_text' => 'hp_attendance_down', 'classroom_id' => NULL],
                ['id' => '16', 'name' => 'hp_eating', 'icon' => 'fas fa-cookie-bite', 'hp' => '-30', 'xp' => '0', 'gold' => '0', 'gems' => '0', 'custom_text' => 'hp_eating', 'classroom_id' => NULL],
                ['id' => '17', 'name' => 'hp_answer_ko', 'icon' => 'far fa-thumbs-down', 'hp' => '-5', 'xp' => '-10', 'gold' => '0', 'gems' => '0', 'custom_text' => 'hp_answer_ko', 'classroom_id' => NULL]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('behaviours');
    }
}
