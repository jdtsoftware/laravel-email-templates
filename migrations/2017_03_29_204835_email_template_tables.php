<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmailTemplateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_layout', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->text('layout');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('email_template', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('owner_id')->unsigned()->nullable();
            $table->integer('layout_id')->unsigned();
            $table->string('handle', 128);
            $table->string('subject', 128);
            $table->text('content');
            $table->string('language', 4)->default('en');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('layout_id')->references('id')->on('email_layout');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_template');
        Schema::dropIfExists('email_layout');
    }
}
