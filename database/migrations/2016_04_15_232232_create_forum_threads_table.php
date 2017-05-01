<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumThreadsTable extends Migration {

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('forum_threads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('forum_id')->unsigned()->index();
            $table->integer('first_post_id')->unsigned()->index();
            $table->string('title')->index();
            $table->boolean('locked');
            $table->integer('locked_by_user_id')->unsigned();
            $table->boolean('pinned');
            $table->integer('pinned_by_user_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            // For faster performance
            $table->integer('total_posts')->index();

            $table->foreign('forum_id')->references('id')->on('forum_forums')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('forum_threads');
    }
}
