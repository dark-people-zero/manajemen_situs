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
        Schema::create('akses_menu', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user');
            $table->string("name");
            $table->boolean('C')->nullable();
            $table->boolean('R')->nullable();
            $table->boolean('U')->nullable();
            $table->boolean('D')->nullable();
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
        Schema::dropIfExists('akses_menu');
    }
};
