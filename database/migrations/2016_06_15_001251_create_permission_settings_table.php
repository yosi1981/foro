<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_category')->default(0);
            $table->integer('parent_id')->default(0);
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permission_settings');
    }
}
