<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreCategoriesTable extends Migration
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

            Schema::connection($connection)->create('wide_store_categories', function (Blueprint $table) {

                $table->bigIncrements('id');
                $table->string('uuid', 36)->index();
                $table->string('parent_uuid', 36)->index()->nullable();
                $table->string('deliverer')->index();
                $table->string('identifier')->index();

                $table->string('name');
                $table->string('lang')->index();

                $table->string('type')->index();
                $table->softDeletes();
                $table->timestamps();

                $table->unique(['deleted_at', 'deliverer', 'identifier', 'lang', 'type'], 'wsc_identifier_deliverer_lang_type');
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

            Schema::connection($connection)->dropIfExists('wide_store_categories');
        }
    }
}
