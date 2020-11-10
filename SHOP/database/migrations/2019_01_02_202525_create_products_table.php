<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
      $table->integer('user_id');
      $table->unsignedSmallInteger('category_id')->nullable();
      $table->string('title');
      $table->longText('content');
      $table->float('price')->nullable();
      $table->float('discounted_price')->nullable();
      $table->integer('quantity')->nullable();
      $table->string('slug')->nullable();
      $table->string('thumbnail')->nullable();
      $table->string('seo_title')->nullable();
      $table->string('seo_description')->nullable();
      $table->boolean('status');
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
