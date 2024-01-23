<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id'); //Add:user_id
            $table->string('item_name'); // 書籍名
            $table->integer('item_number'); // 何冊
            $table->integer('item_amount')->nullable(); // 金額
            $table->string('item_img'); //Add:item_img
            $table->datetime('published'); //出版年月日
            $table->timestamps();
            
            // シリーズ名
            // $table->string('series')->nullable();

            // 著者
            // $table->string('author');

            // 出版社
            // $table->string('publisher');
            // 発行年
            // $table->integer('publication_year');
            // ISBN-10
            // $table->string('ISBN-10')->nullable();
            // ISBN-13
            // $table->string('ISBN-13')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
