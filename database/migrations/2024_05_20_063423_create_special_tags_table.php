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
        Schema::create('special_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name_uz')->nullable();
            $table->string('name_ru')->nullable();
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->string('category_type')->nullable();
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
        Schema::dropIfExists('special_tags');
    }
};
