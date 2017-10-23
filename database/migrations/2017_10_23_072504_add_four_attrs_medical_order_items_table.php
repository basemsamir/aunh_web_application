<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFourAttrsMedicalOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medical_order_items', function (Blueprint $table) {
            //
			$table->string('procedure_status',10)->after('medical_device_procedure_id')->nullable();
			$table->date('procedure_date')->after('procedure_status')->nullable();
			$table->integer('department_id')->after('user_id')->nullable();
			$table->integer('xray_doctor_id')->after('department_id')->nullable();
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_order_items', function (Blueprint $table) {
            //
			$table->dropColumn(['procedure_status','procedure_date','department_id','xray_doctor_id']);
        });
    }
}
