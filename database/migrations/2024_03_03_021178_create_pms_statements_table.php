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
        Schema::create('pms_statements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ref_no')->nullable();
            $table->integer('pms_property_id')->unsigned();
            $table->integer('pms_tenant_id')->unsigned()->nullable();            
            $table->integer('pms_unit_id')->unsigned()->nullable();            
            $table->foreign('pms_property_id')
            ->references('id')
            ->on('pms_properties')
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
            $table->string('payment_method')->nullable(); 
            $table->string('mpesa_code')->nullable(); 
            $table->string('unit_number')->nullable(); 
            $table->integer('status')->nullable()->default(0);
            $table->integer('sms_status')->nullable()->default(0);
            $table->float('total')->nullable();
            $table->float('paid')->nullable();
            $table->float('balance')->nullable();
            $table->float('water_bill')->nullable();
            $table->timestamp('paid_at')->nullable();
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
        Schema::dropIfExists('pms_statements');
    }
};
