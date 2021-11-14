@extends('layouts.app')

@section('title', 'Categories')

@section('content')

    <div class="container">

        @if (session()->has('category_added'))
            @if (session()->get('category_added') == true)
                <div class="alert alert-success mb-3" role="alert">
                    You successfully added a new category!
                </div>
            @endif
        @endif

        @if (session()->has('category_updated'))
            @if (session()->get('category_updated') == true)
                <div class="alert alert-success mb-3" role="alert">
                    You successfully updated a category!
                </div>
            @endif
        @endif

        @if (session()->has('category_deleted'))
            @if (session()->get('category_deleted') == true)
                <div class="alert alert-success mb-3" role="alert">
                    You successfully deleted a category!
                </div>
            @endif
        @endif

        <h3>Categories</h3>
        <br>
        <div class="row">
            <table class="table table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <div class="row justify-content-md-center">
                                <a href="{{ route('edit.category', ['id' => $category->id ]) }}" role="button" class="btn btn-primary"><i class="far fa-edit"></i></a>
                                <form action="{{ route('delete.category', ['id' => $category->id ]) }} " method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">There are no categories yet.</td></tr>
                    @endforelse
                </tbody>
              </table>
        </div>

        <div class="text-center my-3">
            <a href="{{ route('new.category') }}" role="button" class="btn btn-primary"><i class="far fa-plus-square"></i><span class="ml-1">New category</span></a>
        </div>
        <hr>

        <a class="btn btn-primary btn-lg" href="{{ route('main') }}" role="button">
            <i class="fas fa-backward"></i><span class="ml-1">Back to main page</span></a>

    </div>

@endsection
