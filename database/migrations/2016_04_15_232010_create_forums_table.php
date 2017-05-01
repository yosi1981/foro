<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_forums', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->default(0);
            $table->string('name', 175)->index();
            $table->string('description', 500);
            $table->integer('order');
            $table->boolean('closed')->default(0);
            $table->boolean('allow_new_threads')->default(1);
            $table->boolean('enable_rules')->default(0);
            $table->string('rules_title');
            $table->text('rules_description');

            $table->integer('_lft')->unsigned()->index();
            $table->integer('_rgt')->unsigned()->index();

            //For faster performance
            $table->integer('total_posts')->index();
            $table->integer('total_threads')->index();
            $table->integer('last_post_id')->unsigned()->index();
            $table->integer('last_thread_id')->unsigned()->index();
            $table->integer('last_post_user_id')->unsigned()->index();

            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('forum_forums');
    }
}
