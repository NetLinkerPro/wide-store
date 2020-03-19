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

        $connections = array_unique(array_filter([config('database.default'), config('wide-store.connection')], 'strlen'));

        foreach ($connections as $connection) {

            Schema::connection($connection)->create('wide_store_images', function (Blueprint $table) {

                $table->bigIncrements('id');
                $table->string('uuid', 36)->index();
                $table->string('deliverer')->index();
                $table->string('product_uuid', 36)->index();
                $table->string('identifier')->index();

                $table->text('url_source')->nullable();
                $table->string('path')->nullable();
                $table->string('disk')->index()->nullable();
                $table->text('url_target')->nullable();
                $table->integer('order')->default(20);
                $table->boolean('main')->default(false);
                $table->boolean('active')->default(true);

                $table->string('lang')->index();
                $table->string('type')->index();
                $table->softDeletes();
                $table->timestamps();

                $table->unique(['deleted_at', 'product_uuid', 'deliverer', 'identifier', 'lang', 'type'], 'wsi_product_uuid_deliverer_identifier_lang_type');
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

            Schema::connection($connection)->dropIfExists('wide_store_images');
        }
    }
}
