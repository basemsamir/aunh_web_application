<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAndAddAttrToMedicalOrderItemsTable extends Migration
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
			$table->dropColumn('procedure_id');
			$table->integer('medical_device_procedure_id')->after('visit_id')->nullable();
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
			$table->dropColumn('medical_device_procedure_id');
			$table->integer('procedure_id')->after('visit_id')->nullable();
        });
    }
}
