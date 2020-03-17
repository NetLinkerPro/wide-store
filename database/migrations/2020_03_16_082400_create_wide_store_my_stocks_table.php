<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreMyStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wide_store_my_stocks', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('uuid', 36)->index();
            $table->string('owner_uuid', 36)->index();
            $table->string('integration_uuid', 36)->index();
            $table->string('product_uuid', 36)->index();
            $table->string('deliverer')->index();

            $table->integer('stock');
            $table->integer('availability')->index();
            $table->string('department', 128)->index();

            $table->string('type')->index();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['integration_uuid','product_uuid','deliverer', 'department','type'], 'wsms_integ_prod_uuid_deliv_depart_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wide_store_my_stocks');
    }
}
