@extends('layouts.app')

@section('title', 'New item')

@section('content')
    <div class="container">
        <h3>Create new item</h3>
        <form action="{{ route('store.item') }} " method="POST" enctype="multipart/form-data">
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
                    <div class="form-group row">
                        <label for="description" class="col-sm-2 col-form-label">Description:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                            id="description" name="description">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="price" class="col-sm-2 col-form-label">Price:</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                            id="price" name="price" value="{{ old('price') }}" step="0.01">
                            @if ($errors->has('price'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="image" class="col-sm-2 col-form-label">Image:</label>
                        <div class="col-sm-10">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image" @error('image')is-invalid @enderror>
                                <label class="custom-file-label" for="image">Choose image</label>
                                @error('image')
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <h6>
                        Categories:
                    </h6>
                    @forelse($categories as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $category->id }}" id="tag{{ $loop->iteration }}"
                            name="categories[]">
                            <label class="form-check-label" for="tag{{ $loop->iteration }}">
                                {{ $category->name }}
                            </label>
                        </div>
                    @empty
                        <p>There are no categories.</p>
                    @endforelse

                </div>
            </div>
            <div>


            <div class="text-center my-3">
                <button type="submit" class="btn btn-primary">Create item</button>
            </div>

        </form>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('input[type=file]').on('change', (e)=>{
            console.log('changed')
            let target = $(e.currentTarget)
            let fileName = target.val()
            target.next('.custom-file-label').html(fileName)
        })
    </script>
@endsection
