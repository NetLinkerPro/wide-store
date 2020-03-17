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
            $table->string('deliverer')->index();

            $table->mediumText('description');

            $table->string('lang')->index();
            $table->string('type')->index();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['deleted_at','product_uuid','deliverer', 'lang', 'type'], 'wsd_product_uuid_deliverer_lang_type');
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
