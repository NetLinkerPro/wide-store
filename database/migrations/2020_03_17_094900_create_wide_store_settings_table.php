<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateWideStoreSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wide_store_settings', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('uuid', 36)->index();

            $table->string('deliverer')->index();
            $table->string('name');
            $table->string('key')->index();
            $table->mediumText('value')->nullable();

            $table->unique(['deliverer', 'key'], 'wssettings_deliverer_key');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wide_store_settings');
    }
}
