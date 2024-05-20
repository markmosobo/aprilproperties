<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pms_properties', function (Blueprint $table) {
            $table->integer('paybill_number')->nullable(); // Change 'string' to the data type you need
            $table->integer('account_number')->nullable(); // Change 'string' to the data type you need
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pms_properties', function (Blueprint $table) {
            //
        });
    }
};
