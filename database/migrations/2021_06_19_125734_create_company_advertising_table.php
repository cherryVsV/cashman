<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyAdvertisingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_advertising', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->bigInteger('company_id')->unsigned();
            $table->foreign('company_id')
                ->references('id')->on('companies');
            $table->integer('regularity');
            $table->json('properties');
            $table->bigInteger('creator_id')->unsigned();
            $table->foreign('creator_id')
                ->references('id')->on('users');
            $table->boolean('is_active');
            $table->json('images');
            $table->string('type');
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
        Schema::dropIfExists('company_advertising');
    }
}
