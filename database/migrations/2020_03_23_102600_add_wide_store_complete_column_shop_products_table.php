<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class AddWideStoreCompleteColumnProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wide_store_shop_products', function (Blueprint $table) {
            $table->boolean('complete')->index()->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wide_store_shop_products', function (Blueprint $table) {
            $table->dropColumn('complete');
        });
    }
}
