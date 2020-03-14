<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wide_store_descriptions', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('uuid', 36)->index();
            $table->string('product_uuid', 36)->index();
            $table->string('deliverer',24)->index();

            $table->mediumText('description');

            $table->string('lang')->index();
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
        Schema::dropIfExists('wide_store_descriptions');
    }
}
