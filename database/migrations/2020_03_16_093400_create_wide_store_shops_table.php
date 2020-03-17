<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wide_store_shops', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('uuid', 36)->index();
            $table->string('owner_uuid', 36)->index();

            $table->string('integration_uuid')->index();
            $table->string('format_uuid', 36)->index();

            $table->string('name');
            $table->text('description')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->unique(['deleted_at','integration_uuid', 'format_uuid'], 'wsshops_format_integration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wide_store_shops');
    }
}
