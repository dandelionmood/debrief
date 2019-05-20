<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TagSupport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');

            $table->string('label');
            $table->index('label');

            // will be stored as a standard HTML color hex value eg. #aabbcc
            $table->string('colour', 7)
                ->nullable();

            // tags bear a relationship to a given universe
            $table->integer('universe_id', false, true);
            $table->foreign('universe_id')
                ->references('id')->on('universes')
                ->onDelete('cascade');
            
            $table->integer('created_by_user_id', false, true)->nullable();
            $table->foreign('created_by_user_id')->references('id')->on('users');
            $table->integer('last_edited_by_user_id', false, true)->nullable();
            $table->foreign('last_edited_by_user_id')->references('id')->on('users');

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
        Schema::drop('tags');
    }
}
