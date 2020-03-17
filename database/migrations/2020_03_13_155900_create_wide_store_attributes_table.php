<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wide_store_attributes', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('uuid', 36)->index();
            $table->string('product_uuid', 36)->index();
            $table->string('deliverer')->index();
            
            $table->string('name');
            $table->text('value');
            $table->integer('order')->default(20);

            $table->string('lang')->index();
            $table->string('type')->index();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['product_uuid','deliverer', 'name', 'lang','type'], 'wsa_product_uuid_deliverer_name_lang_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wide_store_attributes');
    }
}
