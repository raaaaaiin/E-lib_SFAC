<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string("invoice_no")->nullable();
            $table->string("currency")->nullable();
            $table->string("payer_id")->nullable();
            $table->string("payer_email")->nullable();
            $table->string("refund_url")->nullable();
            $table->string("payer_phone")->nullable();
            $table->string("payer_name")->nullable();
            $table->string("payment_id")->nullable();
            $table->string("payed_amount")->nullable();
            $table->string("payment_status")->nullable();
            $table->string("payment_mode")->nullable();
            $table->string('gateway')->default("paypal");
            $table->string('message')->nullable();
            $table->string('response_code')->nullable();
            $table->string('tran_id')->nullable();
            $table->string('tracking_id')->nullable();
            $table->string('order_id')->nullable();
            $table->string('bank_ref')->nullable();
            $table->text("raw_frontend_request");
            $table->integer("uid")->nullable();
            $table->integer("course_id")->nullable();
            $table->integer("course_year_id")->nullable();
            $table->integer("working_year");
            $table->integer("borrowed_id")->nullable(); // Session aren't guranteed after a transaction occurs.
            $table->string("refund_id")->nullable();
            $table->integer('refund_amount')->nullable();
            $table->string('refund_status')->nullable();
            $table->string('paid_for')->default("fine");
            $table->softDeletes();
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
        Schema::dropIfExists('payments');
    }
}
