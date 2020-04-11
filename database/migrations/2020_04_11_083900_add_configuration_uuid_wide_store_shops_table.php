<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class AddConfigurationUuidWideStoreShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('wide_store_shops', function (Blueprint $table) {

            $table->string('formatter_uuid', 36)->change();

            $table->string('configuration_uuid',36)->index()->nullable();

            $table->dropUnique('wsshops_owner_formatter');

            $table->unique(['deleted_at','owner_uuid', 'formatter_uuid', 'configuration_uuid'], 'wsshops_owner_formatter_configuration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wide_store_shops', function (Blueprint $table) {

            $table->dropColumn('configuration_uuid');
        });
    }
}
