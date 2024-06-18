<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConvertingToUserReferences extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('author');
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('author');
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table->dropColumn('author_id');
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table->dropColumn('author_id');
        });
    }
}
