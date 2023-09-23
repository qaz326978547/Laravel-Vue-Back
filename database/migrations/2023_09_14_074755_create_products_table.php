<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 200); //這邊意思是說title欄位可以為空值 且長度為100
            $table->text('description')->nullable(); //text跟string差別在於text可以存放更多字元
            $table->integer('price');
            $table->string('image', 200)->nullable();
            $table->integer('quantity')->default(1); //default(0)意思是說預設值為0
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
}
