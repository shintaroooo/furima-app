<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('addresses', function (Blueprint $table) {
        $table->dropColumn(['prefecture', 'city', 'street']);

        $table->string('address')->after('postal_code');
    });
}

public function down()
{
    Schema::table('addresses', function (Blueprint $table) {
        $table->string('prefecture')->nullable();
        $table->string('city')->nullable();
        $table->string('street')->nullable();

        $table->dropColumn('address');
    });
}
}
