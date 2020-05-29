@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Drill Register') }}</div>

        <div class="card-body">
          <form action="{{ route('drills.create') }}" method="post">
            @csrf

            @component('components.formError')
              @slot('categories', $categories)
            @endcomponent

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection