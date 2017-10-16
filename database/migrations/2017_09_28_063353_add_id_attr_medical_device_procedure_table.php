<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdAttrMedicalDeviceProcedureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medical_device_procedure', function (Blueprint $table) {
            //
			$table->dropPrimary('medical_device_procedure_primary');
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_device_procedure', function (Blueprint $table) {
            //
			
        });
    }
}
