@extends('layouts.app')

@section('content')
  <div class="app">
    {{-- デフォルトだとこの中ではvue.jsが有効 --}}
    {{-- example-componentはLaravelに入っているサンプルのコンポーネント --}}
    <example-component title="{{ __('Practice').'「'.$drill->title.'」' }}" :drill="{{$drill}}" category-name="{{$category}}" :problems="{{$problems}}"></example-component>
  </div>
@endsection