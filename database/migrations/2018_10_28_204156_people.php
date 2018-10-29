<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class People extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nickname');
            $table->index('nickname');

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();

            // @todo Are more fields needed ? We'll see in time, this is no PIM.

            $table->integer('created_by_user_id', false, true)->nullable();
            $table->foreign('created_by_user_id')->references('id')->on('users');
            $table->integer('last_edited_by_user_id', false, true)->nullable();
            $table->foreign('last_edited_by_user_id')->references('id')->on('users');

            $table->timestamps();
        });

        Schema::create('person_universe', function (Blueprint $table) {
            $table->primary(['person_id', 'universe_id']);

            $table->integer('person_id', false, true);
            $table->foreign('person_id')->references('id')
                ->on('people');

            $table->integer('universe_id', false, true);
            $table->foreign('universe_id')->references('id')
                ->on('universes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_universe');
        Schema::dropIfExists('people');
    }
}
