<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('settings_group_id')->unsigned();
            $table->string('name', 50);
            $table->string('display_name', 300)->nullable();
            $table->text('type');
            $table->string('value')->nullable();
            $table->integer('order');
            $table->boolean('system_required');

            $table->foreign('settings_group_id')->references('id')->on('settings_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings');
    }
}
