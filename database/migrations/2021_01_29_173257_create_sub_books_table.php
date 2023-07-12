<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_books', function (Blueprint $table) {
            $table->id();
            $table->string("sub_book_id");#can be any thing but not empty
            $table->integer("book_id");#foreign key
            $table->integer("borrowed")->default(0);
            $table->integer("price")->default(0);
            $table->integer("condition")->default(1);
            $table->string("remark")->nullable();
            $table->integer("active")->default(1);
            $table->integer("lost_by")->nullable();
            $table->integer("damaged_by")->nullable();
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
        Schema::dropIfExists('sub_books');
    }
}
