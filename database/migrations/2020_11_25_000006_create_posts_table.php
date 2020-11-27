<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('post_text')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('ip_address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
