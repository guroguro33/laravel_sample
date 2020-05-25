@extends('layouts.welcome')

@section('title', 'マイページ')

@section('sidebar')
  @parent

  <p>メインのサイドバー（共通部分）に追加される個別の部分</p>
@endsection

@section('content')
  <p>メインコンテンツ</p>
  @include('common.error', ['text' => 'エラー'])
@endsection

@section('footer')
  @parent

  <script src="dashbord.js"></script>
@endsection
