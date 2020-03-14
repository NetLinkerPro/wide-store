<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wide_store_product_categories', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('product_uuid', 36)->index();
            $table->string('category_uuid', 36)->index();
            $table->string('deliverer',24)->index();

            $table->string('type')->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wide_store_product_categories');
    }
}
