<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeOnProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('type', 20)->after('id')->nullable();
            $table->string('nomor_kamar', 100)->after('type')->nullable();
            $table->string('whatsapp', 100)->after('nomor_kamar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('active_products', function (Blueprint $table) {
            //
        });
    }
}
