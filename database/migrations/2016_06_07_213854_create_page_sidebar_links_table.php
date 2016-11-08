<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageSidebarLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_sidebar_links', function (Blueprint $table) {
            $table->increments('id');
            $table->string('page_id');
            $table->integer('page_module_id');
            $table->string('name');
            $table->string('link');
            $table->string('icon');
            $table->string('type'); // admin, subscriber, public
            $table->integer('order');
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
        Schema::drop('page_sidebar_links');
    }
}
