<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');

            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('remember_token');

            $table->integer('account_id')->unsigned();
            $table->foreign('account_id')
                ->references('id')->on('accounts')
                ->onUpdate('cascade')
                ->onDelete('cascade');

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
