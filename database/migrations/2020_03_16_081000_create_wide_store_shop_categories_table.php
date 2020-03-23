<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreShopCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wide_store_shop_categories', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('uuid', 36)->index();
            $table->string('parent_uuid', 36)->index()->nullable();
            $table->string('owner_uuid', 36)->index();
            $table->string('shop_uuid', 36)->index();
            $table->string('deliverer',24)->index();
            $table->string('identifier',64)->index();

            $table->string('name');
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['deleted_at','parent_uuid', 'shop_uuid', 'deliverer', 'identifier'], 'wssc_parent_shop_deliverer_identifier');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wide_store_shop_categories');
    }
}
