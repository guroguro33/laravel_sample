<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drill extends Model
{
    // DBで間違っても変更させたくないカラム（ユーザーID、管理者権限など）にはロックをかけておく事ができる
    // ロックの掛け方にはfillableぁguardedの２種類がある。
    // どちらかしか指定できない

    // モデルがその属性意外を持たなくなる（fillメソッドに対応しやすいが、カラムが増えるほど足していく必要あり）
    protected $fillable = ['title', 'category_id', "user_id"];
    // モデルからその属性が取り除かれる（カラムが増えてもほとんど変更しなくて良い）
    // protected $guarded = ['id'];

    // リレーションを貼るが、ユーザーは単数型にする
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function problems() {
        return $this->hasMany('App\Problem');
    }
}
