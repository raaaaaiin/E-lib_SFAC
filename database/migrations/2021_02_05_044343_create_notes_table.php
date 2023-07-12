<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id"); // Would be a user with teacher role
            $table->integer("book_id");
            $table->text("note_title"); // Would be a user with teacher role
            $table->longText("note_desc")->nullable(); // Would be a user with teacher role
            $table->integer("note_status")->default(1); // Draft | Publish
            $table->json("files_attached")->nullable();
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
        Schema::dropIfExists('notes');
    }
}
