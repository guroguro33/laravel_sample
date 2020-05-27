<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdDrills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drills', function (Blueprint $table) {
            // DB::statement('~')で~にSQL文を書いて実行できる
            DB::statement('DELETE FROM drills');
            // user_idという名の整数型カラムを生成
            $table->unsignedBigInteger('user_id');
            // user_idをusersテーブルのidのFK（外部キー）とする
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drills', function (Blueprint $table) {
            // 外部キー付きのカラムを削除するにはまず必ず外部キー制約を外す必要があります
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
