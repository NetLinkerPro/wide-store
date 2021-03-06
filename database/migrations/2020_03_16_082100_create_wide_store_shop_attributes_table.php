<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreShopAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wide_store_shop_attributes', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('uuid', 36)->index();
            $table->string('owner_uuid', 36)->index();
            $table->string('shop_uuid', 36)->index();
            $table->string('product_uuid', 36)->index();
            $table->string('deliverer',24)->index();
            
            $table->string('name', 50);
            $table->text('value');
            $table->integer('order')->default(20);

            $table->softDeletes();
            $table->timestamps();

            $table->unique(['deleted_at','shop_uuid','product_uuid','deliverer', 'name'], 'wssa_shop_product_deliverer_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wide_store_shop_attributes');
    }
}
