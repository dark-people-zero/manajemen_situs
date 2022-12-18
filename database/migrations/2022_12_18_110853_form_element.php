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
        Schema::create('form_element', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('id_type_element');
            $table->string('placeholder')->default(null);
            $table->string('option')->default(null);
            $table->string('switch_on')->default(null);
            $table->string('switch_off')->default(null);
            $table->string('is_multiple')->default(null);
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
        Schema::dropIfExists('form_element');
    }
};
