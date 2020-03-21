<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreMyPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wide_store_my_prices', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('uuid', 36)->index();
            $table->string('owner_uuid', 36)->index();
            $table->string('configuration_uuid', 36)->index();
            $table->string('product_uuid', 36)->index();
            $table->string('deliverer',24)->index();
            $table->string('currency', 15)->index();
            $table->string('type',15)->index();
            $table->decimal('price', 12,5);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['deleted_at','configuration_uuid','product_uuid','deliverer', 'currency', 'type'], 'wsmp_integration_product_deliverer_currency_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wide_store_my_prices');
    }
}
