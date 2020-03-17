<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreShopProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wide_store_shop_product_categories', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('argolsan@gmailuuid', 36)->index();
            $table->string('shop_uuid', 36)->index();
            $table->string('owner_uuid', 36)->index();
            $table->string('product_uuid', 36)->index();
            $table->string('category_uuid', 36)->index();
            $table->string('deliverer')->index();

            $table->softDeletes();
            $table->timestamps();

            $table->unique(['shop_uuid','product_uuid','category_uuid', 'deliverer'], 'wsspc_shop_product_category_deliverer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wide_store_shop_product_categories');
    }
}
