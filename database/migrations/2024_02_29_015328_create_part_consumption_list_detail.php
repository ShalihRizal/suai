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
        Schema::create('part_consumption_list_detail', function (Blueprint $table) {
            $table->bigIncrements('part_consumption_list_detail_id');
            $table->integer('part_consumption_list_id')->unsigned();
            $table->integer('part_id')->unsigned();
            $table->string('end_drawing');
            $table->string('no_accessories');
            $table->string('type');
            $table->string('tiang');
            $table->string('qty_per_jb');
            $table->string('qty_total');

            $table->dateTime('created_at');
            $table->bigInteger('created_by')->unsigned();
            $table->dateTime('updated_at')->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();

            // $table->foreign('created_by')
            //     ->references('user_id')
            //     ->on('sys_users')
            //     ->onDelete('cascade');

            // $table->foreign('part_id')
            //     ->references('part_id')
            //     ->on('part')
            //     ->onDelete('cascade');

            // $table->foreign('part_consumption_list_id')
            //     ->references('pcl_id')
            //     ->on('part_consumption_list')
            //     ->onDelete('cascade');

            // $table->foreign('updated_by')
            //     ->references('user_id')
            //     ->on('sys_users')
            //     ->onDelete('cascade');

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
        Schema::dropIfExists('part_consumption_list_detail');
    }
};
