<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreShopImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wide_store_shop_images', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('uuid', 36)->index();
            $table->string('owner_uuid', 36)->index();
            $table->string('shop_uuid', 36)->index();
            $table->string('product_uuid', 36)->index();
            $table->string('deliverer',24)->index();
            $table->string('identifier', 50)->index();

            $table->string('url_target')->nullable();
            $table->integer('order')->default(20);
            $table->boolean('main')->default(false);

            $table->softDeletes();
            $table->timestamps();

            $table->unique(['deleted_at','shop_uuid' ,'product_uuid','deliverer', 'identifier'], 'wssi_shop_product_deliverer_identifier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wide_store_shop_images');
    }
}
