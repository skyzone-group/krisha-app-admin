<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->string('token')->unique();
            $table->string('fcm_token')->nullable();
            $table->timestamp('token_expires_at');
            $table->tinyInteger('is_active')->default(1);
            $table->string('app_lang')->nullable();
            $table->string('os_type')->nullable();
            $table->string('os_version')->nullable();
            $table->string('app_version')->nullable();
            $table->string('device')->nullable();
            $table->string('ip')->nullable();
            $table->timestamp('last_seen_at')->useCurrent();
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
        Schema::dropIfExists('tokens');
    }
}
