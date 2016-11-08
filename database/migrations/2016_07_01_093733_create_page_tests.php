<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageTests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('page_module_id');
            $table->string('link');

            //bool za označavanje je li test generiran od strane admina stranice ili ne
            $table->boolean('isSetTest')->default(false);

            //broj zadataka test
            $table->integer('numTasks')->default(0);
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
        Schema::drop('page_tests');
    }
}
