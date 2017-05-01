<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique()->index();
            $table->string('email')->unique();
            $table->string('avatar')->index();
            $table->boolean('activated');
            $table->string('password');
            $table->timestamp('active_at');
            $table->string('timezone')->index();
            $table->string('about_me', 120)->nullable();
            $table->integer('primary_role')->unsigned();
            $table->string('user_title', 20)->nullable()->index();
            $table->string('signature', 1500)->nullable()->index();
            $table->integer('per_page_posts')->nullable()->index();
            $table->integer('per_page_threads')->nullable()->index();

            $table->boolean('suspend_posts')->default(0);
            $table->boolean('suspend_threads')->default(0);
            $table->boolean('suspend_signature')->default(0);

            $table->string('note_on_user', 500)->nullable();
            $table->string('private_announcement', 255)->nullable();

            $table->string('registration_ip_address', 20);

            $table->rememberToken();
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
        Schema::drop('users');
    }
}
