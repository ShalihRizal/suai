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
        Schema::create('transaksi_in', function (Blueprint $table) {
            $table->bigIncrements('transaksi_in_id');
            $table->string('invoice_no')->nullable();
            $table->string('ata_suai')->nullable();
            $table->string('po_no')->nullable();
            $table->string('po_date')->nullable();
            $table->string('no_urut')->nullable();
            $table->string('part_name')->nullable();
            $table->string('molts_no')->nullable();
            $table->string('part_no')->nullable();
            $table->string('qty')->nullable();
            $table->string('price')->nullable();
            $table->integer('part_id')->nullable();
            $table->string('loc_hib')->nullable();
            $table->string('loc_ppti')->nullable();
            $table->string('qty_end')->nullable();
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
        Schema::dropIfExists('transaksi_in');
    }
};
