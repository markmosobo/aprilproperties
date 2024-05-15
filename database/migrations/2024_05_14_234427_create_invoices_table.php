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
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ref_no')->nullable();
            $table->integer('pms_property_id')->unsigned();
            $table->integer('statement_id')->unsigned();
            $table->integer('pms_tenant_id')->unsigned()->nullable();            
            $table->integer('pms_unit_id')->unsigned()->nullable();            
            $table->foreign('pms_property_id')
            ->references('id')
            ->on('pms_properties')
            ->onDelete('cascade'); 
            $table->foreign('statement_id')
            ->references('id')
            ->on('pms_statements')
            ->onDelete('cascade');  
            $table->foreign('pms_tenant_id')
            ->references('id')
            ->on('pms_tenants')
            ->onDelete('cascade'); 
            $table->foreign('pms_unit_id')
            ->references('id')
            ->on('pms_units')
            ->onDelete('cascade'); 
            $table->string('details')->nullable();
            $table->float('total')->nullable();
            $table->float('water_bill')->nullable();
            $table->integer('status')->nullable();            
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
        Schema::dropIfExists('invoices');
    }
};
