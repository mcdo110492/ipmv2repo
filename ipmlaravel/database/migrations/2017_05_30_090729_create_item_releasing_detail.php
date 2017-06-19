<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemReleasingDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('itemReleasingDetail', function (Blueprint $table) {
            $table->increments('item_releasing_detail_id');
            $table->integer('project_id');
            $table->integer('employee_id');
            $table->string('product_code');
            $table->date('date_release');
            $table->string('remarks');
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
        //
    }
}
