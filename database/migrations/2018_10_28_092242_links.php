<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Links extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relations', function (Blueprint $table) {
            $table->integer('relatable_id', false, true);
            $table->string('relatable_type');
            $table->index(['relatable_type', 'relatable_id']);

            $table->integer('relatable_to_id', false, true);
            $table->string('relatable_to_type');
            $table->index(['relatable_to_type', 'relatable_to_id']);

            $table->index(['relatable_type', 'relatable_id', 'relatable_to_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relations');
    }
}
