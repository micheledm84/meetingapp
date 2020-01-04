<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_participants');
            $table->text('description');
            $table->string('id_room');
            $table->date('date');
            $table->time('start_hour');
            $table->time('end_hour');
            $table->enum('is_active', array(0, 1))->default(1);;
            $table->timestamps();
            $table->foreign('id_room')->references('id')->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meetings');
    }
}
