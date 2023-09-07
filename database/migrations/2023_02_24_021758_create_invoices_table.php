<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('qr_code_id');
            $table->integer('company_id');
            $table->string('invoice_number', 100)->unique();
            $table->string('name', 50);
            $table->dateTime('payment_at')->nullable();
            $table->string('payment_method', 50)->nullable();
            $table->dateTime('started_at');
            $table->dateTime('order_at')->nullable();
            $table->integer('payment_charge')->nullable();
            $table->integer('payment_change')->nullable();
            $table->integer('payment_user')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_generate_report')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
