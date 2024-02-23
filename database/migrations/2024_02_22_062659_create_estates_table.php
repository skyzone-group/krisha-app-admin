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
        Schema::create('estates', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('category_type')->nullable();//flat,home
            $table->integer('region_id')->default(0);
            $table->integer('district_id')->default(0);
            $table->integer('quarter_id')->default(0);
            $table->integer('underground_id')->default(0);
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->boolean('is_owner')->default(false);//object_from_owner
            $table->boolean('is_new')->default(false);//новостройки или вторичка
            $table->integer('home_number')->default(0);
            $table->integer('room_count')->default(0);
            $table->integer('floor')->default(0);
            $table->integer('floor_count')->default(0);
            $table->integer('total_area')->default(0);
            $table->integer('kitchen_area')->default(0);
            $table->integer('land_area')->default(0);//Площадь участка (соток)
            $table->integer('land_area_type')->default(0);//(соток) or gektar
            $table->text('comment')->nullable();
            $table->integer('build_year')->default(0);
            $table->integer('currency_id')->default(0);
            $table->integer('price')->default(0);
            $table->string('price_type')->default('all');
            $table->string('transaction_type');//buy, rent, sell
            $table->boolean('is_barter')->default(false);//новостройки или вторичка
            $table->boolean('is_negotiable')->default(false);//kelishsa bo'ladimi
            $table->boolean('is_home_number_hidden')->default(false);//
            $table->string('video', 50)->nullable();
            $table->integer('ceiling_height')->default(0);
            $table->integer('bathroom_count')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('estates');
    }
};
