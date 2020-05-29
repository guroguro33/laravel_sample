<div>
  <div class="form-group row">
    <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

    <div class="col-md-6">
      <input id="title" type="text" class="form-control @error('title') is-valid @enderror" name="title" value="{{ old('title' , (!empty($drill))? $drill->title : '') }}" autocomplete="title" autofocus>

      @error('title')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>

  <div class="form-group row">
    <label for="category_name" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>

    <div class="col-md-6">
      <select name="category_id" id="category_name" class="form-control @error('category_name') is-valid @enderror" autofocus>
        @foreach($categories as $category)
          <option value="{{ $category->id }}" @if(old('category_id', (!empty($drill))? $drill->category_id : '') == $category->id) selected @endif>{{ $category->category_name }}</option>
        @endforeach
      </select>

      @error('category_id')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>

  {{-- @if($errors->has('username')) ~ @endif --}}
  @for($i = 1; $i <= 10; $i++) 
    <div class="form-group row">
      <label for="problem{{ $i - 1 }}" class="col-md-4 col-form-label text-md-right">{{ __('Problem').$i }}</label>

      <div class="col-md-6">
        <input id="problem{{$i - 1}}" type="text" class="form-control @error('problem'.($i - 1)) is-valid @enderror" name="problem{{ $i - 1 }}" value="{{ old('problem'.($i - 1), (!empty($problem_list[$i - 1]))? $problem_list[$i - 1] : '') }}" autocomplete="" autofocus >
        
        @error('problem'.($i - 1))
        <span class="invalid-feedback" role='alert'>
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
    </div>
  @endfor

  <div class="form-group row mb-0">
    <div class="col-md-6 offset-md-4">
      <button type="submit" class="btn btn-primary">
        {{ __('Register')}}
      </button>
    </div>
  </div>
</div>