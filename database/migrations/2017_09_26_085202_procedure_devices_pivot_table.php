<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedureDevicesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_device_procedure', function (Blueprint $table) {
            $table->integer('procedure_id');
            $table->integer('medical_device_id');
            $table->timestamps();
			$table->primary(['procedure_id', 'medical_device_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('medical_device_procedure');
    }
}
