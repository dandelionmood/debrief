<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universes', function (Blueprint $table) {
            $table->increments('id');
            $table->text('label');
            $table->text('description');

            $table->integer('user_id', false, true);
            $table->foreign('user_id')->references('id')->on('users');

            $table->softDeletes();

            $table->timestamps();
        });

        Schema::create('stories', function (Blueprint $table) {
            $table->increments('id');
            $table->text('label');
            $table->text('description')->nullable();

            $table->integer('universe_id', false, true);
            $table->foreign('universe_id')->references('id')->on('universes');

            $table->softDeletes();

            $table->timestamps();
        });

        Schema::create('meetings', function (Blueprint $table) {
            $table->increments('id');
            $table->text('label');

            $table->integer('universe_id', false, true);
            $table->foreign('universe_id')->references('id')->on('universes');

            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->text('description');

            $table->integer('meeting_id', false, true)->nullable();
            $table->foreign('meeting_id')->references('id')->on('meetings');

            $table->integer('story_id', false, true);
            $table->foreign('story_id')->references('id')->on('story');

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
        Schema::dropIfExists('universes');
        Schema::dropIfExists('stories');
        Schema::dropIfExists('meetings');
        Schema::dropIfExists('comments');
    }
}
