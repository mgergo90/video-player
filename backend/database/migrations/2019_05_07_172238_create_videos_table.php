<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('video_id');
            $table->unsignedBigInteger('play_list_id');
            $table->timestamps();

            $table->foreign('play_list_id')->references('id')->on('play_lists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('play_lists', function (Blueprint $table) {
            $table->dropForeign('videos_play_list_id_foreign');
        });
        Schema::dropIfExists('videos');
    }
}
