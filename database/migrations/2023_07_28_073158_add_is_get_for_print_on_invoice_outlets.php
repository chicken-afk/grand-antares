<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsGetForPrintOnInvoiceOutlets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_outlets', function (Blueprint $table) {
            $table->boolean('is_get_for_print')->default(1)->after('is_printed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_outlets', function (Blueprint $table) {
            //
        });
    }
}
