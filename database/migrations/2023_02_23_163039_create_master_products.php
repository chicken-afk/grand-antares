 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_products', function (Blueprint $table) {
            $table->id();
            $table->integer('outlet_id');
            $table->integer('company_id');
            $table->integer('category_id')->nullable();
            $table->string('product_name');
            $table->text('product_image');
            $table->text('description')->nullable();
            $table->string('sku')->unique();
            $table->integer('price_display');
            $table->integer('price_promo')->nullable() ;
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
        Schema::dropIfExists('master_products');
    }
}
