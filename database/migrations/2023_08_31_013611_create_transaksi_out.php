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
        Schema::create('transaksi_out', function (Blueprint $table) {
            $table->bigIncrements('transaksi_out_id');
            $table->string('condition');
            $table->string('end_stock');
            $table->string('rop');
            $table->string('date_transaksi');
            $table->string('receiving');
            $table->string('balance');
            $table->string('no_urut');
            $table->string('master_part_no');
            $table->string('part_no');
            $table->string('kind');
            $table->string('molts_no');
            $table->string('applicator_no');
            $table->string('part_name');
            $table->string('qty');
            $table->string('machine');
            $table->string('serial_number');
            $table->string('pic');
            $table->string('shift');
            $table->string('stroke');
            $table->string('carline_maker');
            $table->string('remark');
            $table->dateTime('created_at');
            $table->bigInteger('created_by')->unsigned();
            $table->dateTime('updated_at')->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();

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
        Schema::dropIfExists('transaksi_out');
    }
};
