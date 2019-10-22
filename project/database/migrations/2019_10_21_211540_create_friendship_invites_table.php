<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendshipInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friendship_invites', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->integer('inviter_id');
            $table->foreign('inviter_id')
                ->references('id')
                ->on('users');

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
        Schema::dropIfExists('friendship_invites');
    }
}
