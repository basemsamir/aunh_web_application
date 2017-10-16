<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdPrimaryAttrMedicalDeviceProcedureTable extends Migration
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
			$table->increments('id')->before('procedure_id');
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
			$table->dropColumn('id');
        });
    }
}
