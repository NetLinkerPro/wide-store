<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wide_store_products', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('uuid', 36)->index();
            $table->string('category_uuid', 36)->index();
            $table->string('deliverer')->index();
            $table->string('identifier')->index();
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['deleted_at','deliverer', 'identifier'], 'wsp_deliverer_identifier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wide_store_products');
    }
}
