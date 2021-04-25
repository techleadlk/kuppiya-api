<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorBookTable extends Migration
{
    public function up()
    {
        Schema::create('author_book', function (Blueprint $table) {
            $table->foreignId('author_id')->constrained();
            $table->foreignId('book_id')->constrained();
        });
    }

    public function down()
    {
        Schema::dropIfExists('author_book');
    }
}
