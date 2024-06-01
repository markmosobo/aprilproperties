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
        Schema::create('pms_units', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pms_property_id')->unsigned();
            $table->string('unit_number');
            $table->string('type')->nullable();
            $table->float('deposit')->nullable();
            $table->float('monthly_rent')->nullable();
            $table->float('garbage_fee')->nullable();
            $table->float('security_fee')->nullable();
            $table->float('water_deposit')->nullable();
            $table->string('water_meter')->nullable();
            $table->string('electricity_meter')->nullable();
            $table->float('electricity_deposit')->nullable();
            $table->string('paybill_number')->nullable();
            $table->string('account_number')->nullable();
            $table->integer('status')->default(0);
            $table->foreign('pms_property_id')
            ->references('id')
            ->on('pms_properties')
            ->onDelete('cascade');
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
        Schema::dropIfExists('pms_units');
    }
};
