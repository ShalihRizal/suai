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
        Schema::create('part', function (Blueprint $table) {
            $table->bigIncrements('part_id');
            $table->string('part_no')->nullable();
            $table->integer('no_urut')->nullable();
            $table->string('applicator_no')->nullable();
            $table->string('applicator_type')->nullable();
            $table->string('applicator_qty')->nullable();
            $table->string('kode_tooling_bc')->nullable();
            $table->string('part_name')->nullable();
            $table->string('asal')->nullable();     
            $table->string('invoice')->nullable();
            $table->string('po')->nullable();
            $table->dateTime('po_date')->nullable();
            $table->string('rec_date')->nullable();
            $table->string('loc_ppti')->nullable();
            $table->string('loc_tapc')->nullable();
            $table->string('lokasi_hib')->nullable();
            $table->integer('qty_begin');
            $table->integer('qty_in');
            $table->integer('qty_out');
            $table->integer('adjust');
            $table->integer('qty_end');
            $table->string('remarks');
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
        Schema::dropIfExists('part');
    }
};
