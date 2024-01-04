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
        Schema::create('part_consumption_list', function (Blueprint $table) {
            $table->bigIncrements('pcl_id');
            $table->string('pcl_category')->nullable();
            $table->string('family')->nullable();
            $table->integer('part_id')->nullable();
            $table->string('pattern')->nullable();
            $table->string('reason')->nullable();
            $table->string('pic_rec')->nullable();
            $table->string('carname')->nullable();
            $table->string('carline')->nullable();
            $table->string('status')->nullable();
            $table->string('fase')->nullable();
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
        Schema::dropIfExists('part_consumption_list');
    }
};
