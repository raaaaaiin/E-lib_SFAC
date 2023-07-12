<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitor_trackings', function (Blueprint $table) {
            $table->id();
            $table->longText("user_agent")->nullable();
            $table->longText("refer")->nullable();
            $table->string("ip_address")->nullable();
            $table->longText("path")->nullable();
            $table->string("username")->nullable();
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
        Schema::dropIfExists('visitor_trackings');
    }
}
