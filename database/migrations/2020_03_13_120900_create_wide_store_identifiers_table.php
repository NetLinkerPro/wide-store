<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreIdentifiersTable extends Migration
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

            Schema::connection($connection)->create('wide_store_identifiers', function (Blueprint $table) {

                $table->bigIncrements('id');
                $table->string('uuid', 36)->index();
                $table->string('deliverer',24)->index();
                $table->string('product_uuid', 36)->index();
                $table->string('identifier',38)->index();
                $table->string('type',15)->index();

                $table->softDeletes();
                $table->timestamps();

                $table->unique(['deleted_at', 'product_uuid', 'deliverer', 'identifier', 'type'], 'wsi_product_uuid_deliverer_identifier_type');
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

            Schema::connection($connection)->dropIfExists('wide_store_identifiers');

        }
    }
}
