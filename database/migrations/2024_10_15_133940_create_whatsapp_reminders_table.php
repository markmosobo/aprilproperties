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
        Schema::create('whatsapp_reminders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('statement_id')->unsigned();
            $table->foreign('statement_id')
            ->references('id')
            ->on('pms_statements')
            ->onDelete('cascade'); 
            $table->integer('pms_tenant_id')->unsigned()->nullable(); 
            $table->foreign('pms_tenant_id')
            ->references('id')
            ->on('pms_tenants')
            ->onDelete('cascade');
            $table->string('subject')->nullable();
            $table->longText('message')->nullable(); 
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
        Schema::dropIfExists('whatsapp_reminders');
    }
};
