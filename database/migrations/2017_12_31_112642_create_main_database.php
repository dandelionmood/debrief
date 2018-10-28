<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* The universe is the core element */
        Schema::create('universes', function (Blueprint $table) {
            $table->increments('id');
            $table->text('label');
            $table->enum('type', [
                \App\Universe::TYPE_WIKI,
                \App\Universe::TYPE_DIARY,
            ]);
            $table->text('description')->nullable();
            $table->text('picture_url')->nullable();

            $table->index('type');

            $table->timestamps();
        });

        /* Several users can access a given universe */
        Schema::create('universe_user', function (Blueprint $table) {
            $table->integer('universe_id', false, true);
            $table->foreign('universe_id')
                ->references('id')->on('universes')
                ->onDelete('cascade');

            $table->integer('user_id', false, true);
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->primary(['universe_id', 'user_id']);
        });

        /* Universes contains many stories, in a hierarchical fashion */
        Schema::create('stories', function (Blueprint $table) {
            $table->increments('id');
            $table->text('label');
            $table->text('description')->nullable();

            $table->integer('universe_id', false, true);
            $table->foreign('universe_id')
                ->references('id')->on('universes')
                ->onDelete('cascade');

            // Will be null for root stories anyway
            $table->integer('created_by_user_id', false, true)->nullable();
            $table->foreign('created_by_user_id')->references('id')->on('users');
            $table->integer('last_edited_by_user_id', false, true)->nullable();
            $table->foreign('last_edited_by_user_id')->references('id')->on('users');

            // Baum tree required attributes
            $table->integer('parent_id', false, true)->nullable();
            $table->foreign('parent_id')
                ->references('id')->on('story')
                ->onDelete('cascade');
            $table->integer('lft', false, true)->nullable();
            $table->integer('rgt', false, true)->nullable();
            $table->integer('depth', false, true)->nullable();
            $table->index('lft');
            $table->index('rgt');
            $table->index('depth');
            // / Baum tree required attributes

            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');

            $table->integer('story_id', false, true);
            $table->foreign('story_id')
                ->references('id')->on('story')
                ->onDelete('cascade');

            $table->integer('created_by_user_id', false, true);
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
        Schema::dropIfExists('universes');
        Schema::dropIfExists('universe_user');
        Schema::dropIfExists('stories');
        Schema::dropIfExists('comments');
    }
}
