<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteProblemChangeCategoryNameToCategoryIdDrills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drills', function (Blueprint $table) {
            //problemカラムを削除
            $table->dropColumn('problem0');
            $table->dropColumn('problem1');
            $table->dropColumn('problem2');
            $table->dropColumn('problem3');
            $table->dropColumn('problem4');
            $table->dropColumn('problem5');
            $table->dropColumn('problem6');
            $table->dropColumn('problem7');
            $table->dropColumn('problem8');
            $table->dropColumn('problem9');
            // category_nameカラム名を_idに変更
            $table->renameColumn('category_name', 'category_id');
        });

        Schema::table('drills', function (Blueprint $table) {
            // category_idの属性変更
            $table->unsignedBigInteger('category_id')->change();
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
            // category_idの属性変更
            $table->string('category_id')->change();
        });
        Schema::table('drills', function (Blueprint $table) {
            // category_idカラム名をnameに変更
            $table->renameColumn('category_id', 'category_name');
            //problemカラムを追加
            $table->string('problem0');
            $table->string('problem1')->nullable();
            $table->string('problem2')->nullable();
            $table->string('problem3')->nullable();
            $table->string('problem4')->nullable();
            $table->string('problem5')->nullable();
            $table->string('problem6')->nullable();
            $table->string('problem7')->nullable();
            $table->string('problem8')->nullable();
            $table->string('problem9')->nullable();
        });
    }
}
