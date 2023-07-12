<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeweyDecimalClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dewey_decimals', function (Blueprint $table) {
            $table->id();
            $table->string("cat_name");
            $table->integer("parent");
            //$table->integer("sub_parent");
            $table->double("dewey_no",7,4)->nullable();#500.0000 | 500.0100
            $table->integer("shelf_no")->default(0); # if shelf is provided then 500.0104 <04 is the shelf no [99 total shelf] and 01 is subcat Economy(500) > European(500.01)
            $table->string("image")->nullable();
            $table->string("bg_color")->default("#000000");
            $table->string("txt_color")->default("#ffffff");
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
        Schema::dropIfExists('dewey_decimals');
    }
}
