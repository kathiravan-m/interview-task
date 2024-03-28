<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_collection', function (Blueprint $collection) {
            $collection->id();
            $collection->string('courseName');
            $collection->ISODate('startDate');
            $collection->ISODate('endDate');
            $collection->binData('courseImage');
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses_collection');
    }
};
