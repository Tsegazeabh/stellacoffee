<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumTopicRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_topic_replies', function (Blueprint $table) {
            $table->id();
            $table->mediumText('reply_text');
            $table->unsignedBigInteger('forum_topic_id');
            $table->unsignedBigInteger('parent_reply_id')->nullable();
//            $table->morphs('replier');
            $table->timestamps();

            $table->foreign('forum_topic_id')
                ->references('id')
                ->on('forum_topics')
                ->cascadeOnDelete();

            $table->foreign('parent_reply_id')
                ->references('id')
                ->on('forum_topic_replies')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_topic_replies');
    }
}
