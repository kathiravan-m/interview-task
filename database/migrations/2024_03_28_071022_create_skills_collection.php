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
        Schema::create('skills_collection', function (Blueprint $collection) {
            $collection->id();
            $collection->string('skillName');
            $collection->bigInt('capabilityId')->unsigned(); 
            $collection->foreign('capabilityId')->references('id')->on('capabilities_collection')->onDelete('cascade'); 
            $collection->bigInt('courseId')->unsigned(); 
            $collection->foreign('courseId')->references('id')->on('courses_collection')->onDelete('cascade');
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
        Schema::dropIfExists('capabilities_collection');
    }
};
