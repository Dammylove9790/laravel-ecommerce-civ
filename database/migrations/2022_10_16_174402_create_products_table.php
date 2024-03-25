<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('added_by');
            $table->string('role');
            $table->string('name')->unique();
            $table->string('slug');
            $table->string('picture_id');
            $table->integer('price');
            $table->integer('quantity');
            $table->string('measurement');
            $table->text('description');
            $table->string('status');
            $table->json('size');
            $table->json('color');
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
        Schema::dropIfExists('products');
    }
};