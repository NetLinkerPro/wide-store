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

        $connections = array_unique(array_filter([config('database.default'), config('wide-store.connection')], 'strlen'));

        foreach ($connections as $connection) {

            Schema::connection($connection)->create('wide_store_attributes', function (Blueprint $table) {

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

                $table->unique(['deleted_at', 'product_uuid', 'deliverer', 'name', 'lang', 'type'], 'wsa_product_uuid_deliverer_name_lang_type');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $connections = array_unique(array_filter([config('database.default'), config('wide-store.connection')], 'strlen'));

        foreach ($connections as $connection) {

            Schema::connection($connection)->dropIfExists('wide_store_attributes');
        }
    }
}
