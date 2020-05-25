@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-8">
          <div class="card">
            <div class="card-header">{{ __('Practice').'「'.$drill->title.'」' }}</div>
            <div class="card-body text-center">
              <p>{{ $drill->problem0 }}</p>
              <p>{{ $drill->problem1 }}</p>
              <p>{{ $drill->problem2 }}</p>
            </div>
          </div>
        </div>
    </div>
  </div>
@endsection