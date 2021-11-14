@extends('layouts.app')

@section('title', 'All items')

@section('content')
    <div class="container">

        @if (session()->has('success_order'))
            @if (session()->get('success_order') == true)
                <div class="alert alert-success mb-3" role="alert">
                    You successfully made a new order!
                </div>
            @endif
        @endif

        @if (session()->has('item_added'))
            @if (session()->get('item_added') == true)
                <div class="alert alert-success mb-3" role="alert">
                    You successfully created a new item!
                </div>
            @endif
        @endif

        @if (session()->has('item_updated'))
            @if (session()->get('item_updated') == true)
                <div class="alert alert-success mb-3" role="alert">
                    You successfully updated an item!
                </div>
            @endif
        @endif

        @if (session()->has('item_deleted'))
            @if (session()->get('item_deleted') == true)
                <div class="alert alert-success mb-3" role="alert">
                    You successfully deleted an item!
                </div>
            @endif
        @endif

        <h3> Select your favorite items! </h3>
        <div class='row'>
            @if (!Auth::guest() && Auth::user()->is_admin=='1')
                <div class="col align-self-start">
                    <a class="btn btn-primary btn-lg" href="{{ route('new.item') }}" role="button"><i class="far fa-plus-square"></i><span class="ml-1">New item</span></a>
                    <a class="btn btn-outline-danger btn-lg" href="{{ route('deleted.item') }}" role="button"><i class="fas fa-trash"></i><span class="ml-1">Deleted items</span></a>
                </div>
            @endif
            <div class="col align-self-end text-right">
                <a class="btn btn-primary btn-lg" href="{{ route('main') }}" role="button">
                    <i class="fas fa-backward"></i><span class="ml-1">Back to main page</span></a>
                <br>
            </div>
        </div>
        <hr>

        @foreach($categories as $category)
        <h3>Category: {{ $category->name }}</h3>
        <hr>
        <div class="row text-center">
                @forelse ($category->items as $item)
                    <div class="col-12 col-lg-4 mb-2">
                        <div style="background: rgb(175, 238, 238) !important; height: 450px;" class="card">
                            <div class="card-body">
                                <div class="row">
                                <div class="col sm-4">
                                    @if ($item->image_url!==null)
                                        <img src="{{  Storage::url('images/item_images/' . $item->image_url) }}" alt="Item image" width="120" height="120"/>
                                    @else
                                        <img src="{{ url('000000.png') }}" alt="Item image" width="120" height="120"/>
                                    @endif
                                    <br><br>
                                    @if (!Auth::guest() && Auth::user()->is_admin=='1')
                                    <a class="btn btn-primary" href="{{ route('edit.item', ['id' => $item->id]) }}" role="button"><i class="far fa-edit"></i><span class="ml-1">Edit</span></a>
                                    <a class="btn btn-danger" href="{{ route('delete.item', ['id' => $item->id]) }}" role="button"><i class="far fa-trash-alt"></i><span class="ml-1">Delete</span></a>
                                    @else
                                    <form action=" {{ route('add.cart', ['itemId' => $item->id]) }} " method="POST"
                                        class="form-inline justify-content-center">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <input type="number" class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}"
                                                        @guest disabled @endguest id="quantity" name="quantity" min="1" max="10" value="1">
                                                        @if ($errors->has('quantity'))
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $errors->first('quantity') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-primary" @guest disabled @endguest>
                                                    <i class="fas fa-cart-plus"></i><span class="ml-1">Add to cart</span></button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                                <div class="col sm-4">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $item->description }}</h6>
                                    <h5 style="color: blue" class="mb-2">Price: {{ $item->price }} $</h5>

                                    {{-- kategóriák --}}
                                    @foreach ($item->categories as $c)
                                        <span class="badge badge-dark">{{ $c->name }}</span>
                                    @endforeach

                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                @empty
                <div class="col align-self-end text-centered">
                    There are no items yet.
                </div>
                @endforelse
        </div>
        @endforeach
    </div>

@endsection
