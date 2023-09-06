<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_products', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 100);
            $table->integer('user_id');
            $table->integer('company_id');
            $table->boolean('is_bundle')->default(0);
            $table->boolean('is_active')->default(1);
            $table->string('active_product_name');
            $table->string('product_image');
            $table->text('description');
            $table->string('sku')->unique();
            $table->integer('price_display');
            $table->integer('price_promo')->nullable();
            $table->integer('outlet_id')->nullable();
            $table->boolean('is_available')->default(1);
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
        Schema::dropIfExists('active_products');
    }
}
