<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wide_store_stocks', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('uuid', 36)->index();
            $table->string('product_uuid', 36)->index();
            $table->string('deliverer',24)->index();

            $table->integer('stock');
            $table->integer('availability')->index();
            $table->string('department', 128)->index();

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
        Schema::dropIfExists('wide_store_stocks');
    }
}
