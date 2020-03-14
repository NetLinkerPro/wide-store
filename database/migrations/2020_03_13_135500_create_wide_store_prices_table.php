<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStorePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wide_store_prices', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('uuid', 36)->index();
            $table->string('product_uuid', 36)->index();
            $table->string('deliverer',24)->index();
            $table->string('currency', 48)->index();
            $table->string('type')->index();
            $table->decimal('price', 12,5);
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
        Schema::dropIfExists('wide_store_prices');
    }
}
