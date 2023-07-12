<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticeManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notice_managers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text("notice");
            $table->json("role_id");# List ,
            $table->json("user_id");# List ,
            $table->integer("active")->default(0);
            $table->string("show_in")->default('back_end');
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
        Schema::dropIfExists('notice_managers');
    }
}
