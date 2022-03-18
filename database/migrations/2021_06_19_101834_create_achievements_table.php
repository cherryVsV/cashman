<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('achievement_description');
            $table->string('achievement_image_url');
            $table->bigInteger('stat_id')->unsigned();
            $table->foreign('stat_id')
                ->references('id')->on('characteristics');
            $table->string('value');
            $table->string('position');
            $table->text('prize_description');
            $table->string('prize_image_url');
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('achievements');
    }
}
