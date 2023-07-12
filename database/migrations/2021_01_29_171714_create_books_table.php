<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string("unique_id");
            $table->string("isbn_10")->nullable();;# 10 digit unique_identifier
            $table->string("isbn_13")->nullable();;# 13 digit unique_identifier
            $table->string("title");
            $table->text("desc")->nullable();
            //$table->string("category")->default("Others");
            //$table->string("author")->nullable();
            $table->string("publisher")->nullable();
            $table->string("preview_url")->nullable(); #google preview
            $table->string("custom_file")->nullable(); # uploaded file
            $table->integer("category")->nullable(); #
            $table->json("publisher")->nullable(); #
            $table->json("author")->nullable(); #
            $table->text("cover_img")->nullable();
            $table->integer("active")->default(1);
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
        Schema::dropIfExists('books');
    }
}
