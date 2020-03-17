<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreIntegrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wide_store_integrations', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('uuid', 36)->index();
            $table->string('owner_uuid', 36)->index();

            $table->string('deliverer')->index();
            $table->string('deliverer_configuration_uuid', 36)->index();

            $table->softDeletes();
            $table->timestamps();

            $table->unique(['deleted_at','deliverer_configuration_uuid'], 'wsintegrations_deliverer_configuration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wide_store_integrations');
    }
}
