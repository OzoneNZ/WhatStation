<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            // Genre relationship
            $table->integer('genre_id')->unsigned();
            $table->foreign('genre_id')->references('id')->on('genres');

            // Station information
            $table->string('name', 64)->unique();
            $table->string('image_url', 255);
            $table->string('web_url', 128);
            $table->string('wiki_title', 64);

            // Timestamps
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stations');
    }
}
