<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // モデル同士のリレーションを貼ることにより自動的にテーブル結合をする
    // function名は慣習としてモデル名にする
    public function drills() {
        return $this->hasMany('App\Drill');
    }

    // drillを経由して１つのカテゴリーにアクセス(第３引数はDrillテーブルの外部キー)
    public function drillCategory() {
        return $this->hasOneThrough('App\Category', 'App\Drill', 'category_id');
    }

    // drillを経由して多数のproblemにアクセス(第３引数はDrillテーブルの外部キー)
    public function drillProblems() {
        return $this->hasManyThrough('App\Problem', 'App\Drill', 'id');
    }
}
