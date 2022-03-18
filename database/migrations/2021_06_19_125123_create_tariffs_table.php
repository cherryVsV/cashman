<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->float('money');
            $table->string('title');
            $table->text('description');
            $table->boolean('is_visible');
            $table->json('properties');
            $table->string('identifier')->unique();
            $table->string('stripe_id')->unique();
            $table->integer('stories')->nullable();
            $table->integer('news')->nullable();
            $table->integer('admins')->nullable();
            $table->boolean('is_vk_upload')->default(false);
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
        Schema::dropIfExists('tariffs');
    }
}
