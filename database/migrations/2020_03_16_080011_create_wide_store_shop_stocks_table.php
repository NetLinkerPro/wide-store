<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreShopStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wide_store_shop_stocks', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('uuid', 36)->index();
            $table->string('owner_uuid', 36)->index();
            $table->string('shop_uuid', 36)->index();
            $table->string('product_uuid', 36)->index();
            $table->string('deliverer',24)->index();

            $table->integer('stock');
            $table->integer('availability')->index();
            $table->string('department', 36)->index();

            $table->softDeletes();
            $table->timestamps();

            $table->unique(['deleted_at','shop_uuid', 'product_uuid','deliverer', 'department'], 'wsss_shop_product_deliverer_department');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wide_store_shop_stocks');
    }
}
