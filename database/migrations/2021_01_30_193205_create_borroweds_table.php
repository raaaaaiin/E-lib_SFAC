<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borroweds', function (Blueprint $table) {
            $table->id();
            $table->integer("sub_book_id");
            $table->integer("book_id");
            $table->integer("user_id");
            $table->text("remark")->nullable();
            $table->date("date_borrowed");
            $table->date("date_to_return");
            $table->date("date_returned")->nullable();
            $table->integer("delayed_day")->nullable();
            $table->float("fine")->nullable();
            $table->integer("issued_by");
            $table->integer("working_year");
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
        Schema::dropIfExists('borroweds');
    }
}
