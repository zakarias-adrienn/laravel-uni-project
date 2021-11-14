<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->string('address')->default('');
            $table->string('comment')->nullable();
            $table->date('received_on')->nullable();
            $table->date('processed_on')->nullable();
            $table->enum('payment_method', ['CASH', 'CARD'])->default('CASH');
            $table->enum('status', ['CART', 'RECEIVED', 'REJECTED', 'ACCEPTED']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // kell majd idegen kulcsként a user_id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
