<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wide_store_images', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('uuid', 36)->index();
            $table->string('product_uuid', 36)->index();
            $table->string('deliverer',24)->index();
            $table->string('identifier')->index();

            $table->string('url_source')->nullable();
            $table->string('path')->nullable();
            $table->string('disk')->nullable();
            $table->string('url_target')->nullable();
            $table->integer('order')->default(20);
            $table->boolean('main')->default(false);
            $table->boolean('active')->default(true);

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
        Schema::dropIfExists('wide_store_images');
    }
}
