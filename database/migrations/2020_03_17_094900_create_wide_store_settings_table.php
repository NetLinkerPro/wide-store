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

            $table->string('deliverer',24)->index();
            $table->string('name');
            $table->string('key', 64)->index();
            $table->mediumText('value')->nullable();

            $table->unique(['deleted_at','deliverer', 'key'], 'wssettings_deliverer_key');

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
