<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListenedTable extends Migration
{
    public function up()
    {
        Schema::create('listened', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('title');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('listened');
    }
}