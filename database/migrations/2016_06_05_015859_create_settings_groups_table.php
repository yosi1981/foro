<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id');
            $table->integer('is_category');
            $table->string('name');
            $table->string('display_name', 50);
            $table->string('description', 250);
            $table->integer('order');
            $table->boolean('system_required');
            $table->string('icon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings_groups');
    }
}
