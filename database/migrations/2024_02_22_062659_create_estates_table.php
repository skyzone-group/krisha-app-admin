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
            $table->string('home_number')->nullable();
            $table->integer('room_count')->default(0);
            $table->integer('floor')->default(0);
            $table->integer('floor_count')->default(0);
            $table->double('total_area', 15, 4)->default(0); // Specify precision and scale
            $table->double('kitchen_area', 15, 4)->default(0); // Specify precision and scale
            $table->double('land_area', 15, 4)->default(0); // Specify precision and scale
            $table->string('land_area_type')->nullable(); // (ar) or hectare
            $table->text('comment')->nullable();
            $table->string('build_year')->nullable();
            $table->string('currency')->default('usd');
            $table->double('price', 15, 8)->default(0);//Specify precision and scale
            $table->string('price_type')->default('all'); // mkv or all | default all
            $table->string('transaction_type');//buy, rent, sell
            $table->boolean('is_barter')->default(false);//новостройки или вторичка
            $table->boolean('is_negotiable')->default(false);//kelishsa bo'ladimi
            $table->boolean('is_home_number_hidden')->default(false);
            $table->string('video', 50)->nullable();
            $table->double('ceiling_height', 15, 4)->default(0); // Specify precision and scale
            $table->integer('bathroom_count')->default(0);
            $table->string('landmark')->nullable(); //ориентир
            $table->boolean('is_pledged')->default(false); //в залоге
            $table->boolean('is_dormitory')->default(false); //Бывшее общежитие
            $table->boolean('is_kitchen_studio')->default(false); //Кухня студия
            $table->boolean('has_basement')->default(false); //Есть цокольный этаж
            $table->boolean('has_attic')->default(false); //Есть мансарда
            $table->boolean('has_fence')->default(false); //Есть забор
            $table->boolean('has_tenants')->default(false); //Есть арендаторы
            $table->boolean('documents_in_order')->default(false); //Документы в порядке
            $table->boolean('house_and_land_pledged')->default(false); //Дом и дача в залоге
            $table->boolean('three_phase_power')->default(false); //подведено 3 фазы
            $table->boolean('free_layout')->default(false); //Свободная планировка
            $table->string('roof_cover')->nullable(); //Покрытие крыши
            $table->string('how_fenced_plot')->nullable(); //Как огорожен участок
            $table->string('dedicated_power', 50)->nullable(); //Выделенная мощность, квт
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
