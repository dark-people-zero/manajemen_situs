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
        Schema::create('situs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('status_desktop');
            $table->boolean('status_mobile');
            $table->string('url_desktop_dev')->nullable();
            $table->string('url_desktop_prod')->nullable();
            $table->string('url_mobile_dev')->nullable();
            $table->string('url_mobile_prod')->nullable();
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
        Schema::dropIfExists('situs');
    }
};
