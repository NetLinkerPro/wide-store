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

        Schema::create('wide_store_categories', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('uuid', 36)->index();
            $table->string('parent_uuid', 36)->index()->nullable();
            $table->string('deliverer')->index();

            $table->string('name');
            $table->string('lang')->index();

            $table->string('type')->index();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['parent_uuid','deliverer', 'name','lang', 'type'], 'wsc_parent_uuid_deliverer_name_lang_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wide_store_categories');
    }
}
