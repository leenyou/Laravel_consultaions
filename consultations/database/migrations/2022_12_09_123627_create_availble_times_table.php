<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('availble_times', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expert_id');
            // $table->unsignedBigInteger('day_id');
            $table->datetime('From');
            $table->datetime('To');
            $table->timestamps();

            $table->foreign('expert_id')
                 ->references('id')->on('experts')
                 ->onDelete('cascade');
            // $table->foreign('day_id')
            //      ->references('id')->on('days')
            //      ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('availble_times');
    }
};
