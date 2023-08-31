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
        Schema::create('part_request', function (Blueprint $table) {
            $table->bigIncrements('part_req_id');
            $table->bigInteger('part_id')->unsigned()->nullable();
            $table->string('part_req_number')->nullable();
            $table->string('carline', 100);
            $table->string('car_model', 100);
            $table->string('alasan');
            $table->string('order');
            $table->string('shift');
            $table->string('machine_no');
            $table->string('applicator_no');
            $table->string('wear_and_tear_code');
            $table->string('serial_no');
            $table->string('side_no');
            $table->string('stroke');
            $table->string('pic');
            $table->string('remarks');
            $table->integer('anvil_qty');
            $table->integer('insulation_crimper_qty');
            $table->integer('wire_crimper_qty');
            $table->dateTime('created_at');
            $table->bigInteger('created_by')->unsigned();
            $table->dateTime('updated_at')->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();

            $table->foreign('part_id')
                ->references('part_id')
                ->on('part')
                ->onDelete('cascade');

            $table->foreign('created_by')
                ->references('user_id')
                ->on('sys_users')
                ->onDelete('cascade');

            $table->foreign('updated_by')
                ->references('user_id')
                ->on('sys_users')
                ->onDelete('cascade');
            
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('part_request');
    }
};
