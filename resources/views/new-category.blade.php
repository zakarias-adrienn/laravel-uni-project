@extends('layouts.app')

@section('title', 'New category')

@section('content')
    <div class="container">
        <h3>Create new category</h3>
        <form action="{{ route('store.category') }}" method="POST">
            @csrf

            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            id="name" name="name" value="{{ old('name') }} ">
                            @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div>

            <div class="text-center my-3">
                <button type="submit" class="btn btn-primary">Create category</button>
            </div>

        </form>
    </div>
@endsection
