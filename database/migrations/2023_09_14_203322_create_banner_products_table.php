<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('banner_id');
            $table->foreign('banner_id')->references('id')->on('banners');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('active_products');
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
        Schema::dropIfExists('banner_products');
    }
}
