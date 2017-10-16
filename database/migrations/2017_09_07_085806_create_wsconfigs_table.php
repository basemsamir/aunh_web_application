<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWsconfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wsconfigs', function (Blueprint $table) {
            $table->increments('id');
            $table->text('url');
            $table->string('sending_app');
            $table->string('sending_fac');
            $table->string('receiving_app');
            $table->string('receiving_fac');
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
        Schema::drop('wsconfigs');
    }
}
