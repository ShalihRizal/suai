<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
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
            $table->string('alasan')->nullable();
            $table->string('order')->nullable();
            $table->string('shift')->nullable();
            $table->string('machine_no')->nullable();
            $table->string('applicator_no')->nullable();
            $table->string('wear_and_tear_code')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('side_no')->nullable();
            $table->string('stroke')->nullable();
            $table->string('pic')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('part_qty')->nullable();
            $table->string('status')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('part_no')->nullable();
            $table->string('part_rec_pic_path')->nullable();
            $table->string('part_rec_pic_filename')->nullable();
            $table->string('wear_and_tear_status')->nullable();
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
