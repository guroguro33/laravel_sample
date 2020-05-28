<?php

namespace App\Http\Controllers;

use App\Drill;
use App\Problem;
use App\Category;
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
    $categories = Category::all();
    return view('drills.new', ['categories' => $categories]);
  }

  public function create(Request $request) // Requestクラスのインスタンス$requestを引数にとる
  {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer',
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
        $problem = new Problem;
        $category = new Category;

        // 1つ1つ入れるか
        // $drill->title = $request->title;
        // $drill->category_name = $request->category_name;
        // $drill->save();

        // fillを使って一気にいれるか
        // fillableを使っていないと変なデータが入り込んだ場合に勝手にDBが更新されてしまうので注意
        // $drill->fill($request->all())->save()

        // user_idも含めた場合
        Auth::user()->drills()->save($drill->fill($request->all()));

        // // categoryテーブルの処理
        // $category->category_name = $request->category_name;
        // $category->save();

        // // drillsテーブルにカテゴリーIDを追加
        // $drill->category_id = $category->id;
        // $drill->save();

        // problemsテーブルの処理
        $problems = [];
        $i = 0;
        $problem_name = 'problem'.$i; 

        while(!empty($request->$problem_name)){
          $problems[] = ['description' => $request->$problem_name];
          $i++;
          $problem_name = 'problem'.$i;
        }

        // createManyで複数のproblemに登録
        $drill->problems()->createMany($problems);

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

    $problems = Problem::where('drill_id', 6)->get();

    // $problems = $drill->problems()->get();

    var_dump($drill->id);
    // var_dump($problems);

    $categories = Category::all();

    return view('drills.edit', ['drill' => $drill, 'categories' => $categories, 'problems' => $problems]); // viewに変数drillを渡す
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