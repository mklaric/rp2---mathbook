<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('page_id');
            $table->boolean('immutable');
            $table->string('type'); // PageNotifications, PageSettings, ...
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
        Schema::drop('page_modules');
    }
}
