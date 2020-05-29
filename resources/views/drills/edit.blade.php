@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Drill Updater') }}</div>

        <div class="card-body">
          {{-- $drill->idで、ルーティングの$idに値を入れる --}}
          <form action="{{ route('drills.update', $drill->id) }}" method="post"> 
            @csrf

            @component('components.formError')
              @slot('drill', $drill)
              @slot('problem_list', $problem_list)
              @slot('categories', $categories)
            @endcomponent
            
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection