<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('event_user', function (Blueprint $table) {
            $table->unsignedInteger('event_id');
            $table->foreign('event_id', 'event_id_fk_1423984')->references('id')->on('events')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_1423984')->references('id')->on('users')->onDelete('cascade');
        });

    }
}
