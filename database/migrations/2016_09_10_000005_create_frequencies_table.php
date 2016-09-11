<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrequenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frequencies', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            // Station relationship
            $table->integer('station_id')->unsigned();
            $table->foreign('station_id')->references('id')->on('stations');

            // Region relationship
            $table->integer('region_id')->unsigned();
            $table->foreign('region_id')->references('id')->on('regions');

            // City relationship
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities');

            // Frequency information
            $table->string('frequency', 8);
            $table->string('band', 2);

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
        Schema::drop('frequencies');
    }
}
