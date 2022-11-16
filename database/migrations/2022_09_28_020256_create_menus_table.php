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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('nama');
            $table->string('link');
            $table->string('status');
            $table->string('icon2');
            $table->string('icon1');
            $table->integer('level1')->default(0);
            $table->integer('level2')->default(0);
            $table->integer('level3')->default(0);
            $table->integer('level4')->default(0);
            $table->integer('level5')->default(0);
            $table->integer('level6')->default(0);
            $table->integer('level7')->default(0);
            $table->integer('level8')->default(0);
            $table->string('keterangan');
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
        Schema::dropIfExists('menus');
    }
};
