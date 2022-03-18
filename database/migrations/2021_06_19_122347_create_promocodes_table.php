<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromocodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promocodes', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->integer('activation_count')->nullable();
            $table->boolean('is_active');
            $table->bigInteger('company_id')->unsigned();
            $table->foreign('company_id')
                ->references('id')->on('companies');
            $table->bigInteger('creator_id')->unsigned();
            $table->foreign('creator_id')
                ->references('id')->on('users');
            $table->text('prize_value');
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
        Schema::dropIfExists('promocodes');
    }
}
