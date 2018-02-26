<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryAttrMedicalDeviceTypesTb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medical_device_types', function (Blueprint $table) {
            //
            $table->integer('medical_device_category_id')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_device_types', function (Blueprint $table) {
            //
            $table->dropColumn('medical_device_category_id');
        });
    }
}
