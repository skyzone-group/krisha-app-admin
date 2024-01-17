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
        Schema::create('story_items', function (Blueprint $table) {
            $table->id();
            $table->integer('story_category_id')->default(0);
            $table->string('title_uz')->nullable();
            $table->string('title_ru')->nullable();
            $table->string('title_en')->nullable();
            $table->string('subtitle_uz')->nullable();
            $table->string('subtitle_ru')->nullable();
            $table->string('subtitle_en')->nullable();
            $table->string('file')->nullable();
            $table->string('file_type')->nullable();
            $table->string('link')->nullable();
            $table->integer('estate_id')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('story_items');
    }
};
