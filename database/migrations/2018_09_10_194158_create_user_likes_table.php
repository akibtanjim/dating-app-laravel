<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_likes')) {
            Schema::create('user_likes', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->integer('liked_person');
                $table->boolean('status')->default(false);
                $table->boolean('is_seen_by_user')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_likes');
    }
}
