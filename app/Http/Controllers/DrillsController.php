<?php

namespace App\Http\Controllers;

use App\Drill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DrillsController extends Controller
{
  public function index()
  {
    $drills = Drill::all(); // Drillの全データ取得
    return view('drills.index', ['drills' => $drills]);

  }

  public function show($id)
  {
    if(!ctype_digit($id)){
      return redirect('/drills/new')->with('flash_message', __('Invalid operation was performed.'));
    }
    $drill = Drill::find($id);
    return view('drills.show', ['drill' => $drill]);

  }

  public function new()
  {
    return view('drills.new');
  }

  public function create(Request $request) // Requestクラスのインスタンス$requestを引数にとる
  {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_name' => 'required|string|max:255',
            'problem0' => 'required|string|max:255',
            'problem1' => 'string|nullable|max:255',
            'problem2' => 'string|nullable|max:255',
            'problem3' => 'string|nullable|max:255',
            'problem4' => 'string|nullable|max:255',
            'problem5' => 'string|nullable|max:255',
            'problem6' => 'string|nullable|max:255',
            'problem7' => 'string|nullable|max:255',
            'problem8' => 'string|nullable|max:255',
            'problem9' => 'string|nullable|max:255',
        ]);

        // モデルを使って、DBに登録する値をセット
        $drill = new Drill;

        // 1つ1つ入れるか
        // $drill->title = $request->title;
        // $drill->category_name = $request->category_name;
        // $drill->save();

        // fillを使って一気にいれるか
        // fillableを使っていないと変なデータが入り込んだ場合に勝手にDBが更新されてしまうので注意
        // $drill->fill($request->all())->save()

        // user_idも含めた場合
        Auth::user()->drills()->save($drill->fill($request->all()));

        // リダイレクトする
        // その時にsessionフラッシュにメッセージを入れる
        return redirect('/drills/new')->with('flash_message', __('Registered'));
  }

  public function edit($id){ // $idと引数を用意すると、ルーティングのパラメータが自動的に入ってくる
    // GETパラメータが数字がどうかチェックする
    // 事前にチェックしておくことでDBへの無駄なアクセスが減らせる（WEBサーバーへのアクセスのみで済む）
    if(!ctype_digit($id)){ // $idが数字かチェックする
      return redirect('/drills/new')->with('flash_message', __('Invalid operation was performed.'));
    }
    // $drill = Drill::find($id);
    $drill = Auth::user()->drills()->find($id);
    return view('drills.edit', ['drill' => $drill]); // viewに変数drillを渡す
  }

  public function update(Request $request, $id){ // 2つの引数をとる
    // GETパラメータが数字かどうかをチェックする
    if(!ctype_digit($id)){
      return redirect('/drills/new')->with('flash_message', __('Invalid operation was performed.'));
    } 
    // $drill = Drill::find($id);
    $drill = Auth::user()->drills()->find($id);
    $drill->fill($request->all())->save();

    return redirect('/drills')->with('flash_message', __('Registered'));

  }

  public function destroy($id){
    // GETパラメータが数字かどうかをチェックする
    if(!ctype_digit($id)){
      return redirect('/drills/new')->with('flash_message', __('Invalid operation was performed'));
    }

    // delete方法その１
    // $drill = Drill::find($id);
    // $drill->delete();

    // こう書いた方がスマート
    // Drill::find($id)->delete();
    Auth::user()->drills()->find($id)->delete();

    return redirect('/drills')->with('flash_message', __('Deleted.'));
  }

  public function mypage() {

    // Authファサードからuserモデルが取得できるため、そこからリレーションを張っているdrillsモデルを操作
    $drills = Auth::user()->drills()->get();

    // viewに変数を渡す際にcompact関数かwith関数を使用する
    return view('drills.mypage', compact('drills'));
    // withの場合
    // return view('drills.mypage')->with('drills', $drills);
  }

}