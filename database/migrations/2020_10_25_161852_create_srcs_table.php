<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSrcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srcs', function (Blueprint $table) {
            $table->id();
            $table->string('faculty', 10);
            $table->string('course', 10);
            $table->string('src', 200);
            $table->boolean('status')->default(0);
            $table->dateTime('cron_updated')->nullable();
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
        Schema::dropIfExists('srcs');
    }
}
