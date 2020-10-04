<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id')->nullable(false);
            $table->string('day', 40)->nullable(false);
            $table->string('subject', 255)->nullable(false);
            $table->integer('number_subject')->nullable(false);
            $table->integer('number_week')->nullable(false);
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
