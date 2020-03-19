<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreProductCategoriesTable extends Migration
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

            Schema::connection($connection)->create('wide_store_product_categories', function (Blueprint $table) {

                $table->bigIncrements('id');
                $table->string('product_uuid', 36)->index();
                $table->string('category_uuid', 36)->index();
                $table->string('deliverer')->index();

                $table->string('type')->index();
                $table->softDeletes();
                $table->timestamps();

                $table->unique(['deleted_at', 'product_uuid', 'category_uuid', 'deliverer', 'type'], 'wspc_product_uuid_category_uuid_deliverer_type');
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

            Schema::connection($connection)->dropIfExists('wide_store_product_categories');
        }
    }
}
