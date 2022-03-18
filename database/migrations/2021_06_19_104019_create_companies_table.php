<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('domain')->unique();
            $table->string('password');
            $table->integer('cashback_percent_level_1')->nullable();
            $table->integer('cashback_percent_level_2')->nullable();
            $table->integer('cashback_percent')->nullable();
            $table->text('description');
            $table->string('image');
            $table->float('latitude', 8, 6);
            $table->float('longitude', 8, 6);
            $table->string('position')->nullable();
            $table->string('personal_rating')->nullable();
            $table->bigInteger('company_group_id')->unsigned()->nullable();
            $table->foreign('company_group_id')
                ->references('id')->on('group_companies');
            $table->json('properties')->nullable();
            $table->string('callback_url')->nullable();
            $table->json('socials')->nullable();
            $table->boolean('is_active')->nullable();
            $table->string('upload_vk_url')->nullable();
            $table->bigInteger('creator_id')->unsigned();
            $table->foreign('creator_id')
                ->references('id')->on('users');

            $table->foreign('tariff_id')
                ->references('id')->on('tariffs');
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
        Schema::dropIfExists('companies');
    }
}
