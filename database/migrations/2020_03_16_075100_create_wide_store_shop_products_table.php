<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreShopProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wide_store_shop_products', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('uuid', 36)->index();
            $table->string('owner_uuid', 36)->index();
            $table->string('shop_uuid', 36)->index();
            $table->string('source_uuid', 36)->index()->nullable();
            $table->string('category_uuid', 36)->index();
            $table->string('deliverer',24)->index();
            $table->string('identifier',38)->index();
            $table->string('name');
            $table->decimal('price', 12,5);
            $table->integer('tax')->index();
            $table->string('url')->nullable();
            $table->boolean('complete')->index()->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['deleted_at','shop_uuid', 'identifier'], 'wssp_shop_identifier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wide_store_shop_products');
    }
}
