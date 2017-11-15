<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeAttrToMedicalDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medical_devices', function (Blueprint $table) {
            //
            $table->integer('medical_device_type_id')->after('name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_devices', function (Blueprint $table) {
            //
            $table->dropColumn(['medical_device_type_id']);
        });
    }
}
