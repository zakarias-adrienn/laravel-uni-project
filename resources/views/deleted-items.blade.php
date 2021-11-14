@extends('layouts.app')

@section('title', 'Deleted items')

@section('content')
    <div class="container">

        @if (session()->has('item_restored'))
            @if (session()->get('item_restored') == true)
                <div class="alert alert-success mb-3" role="alert">
                    You successfully restored an item!
                </div>
            @endif
        @endif

        @if (session()->has('cannot_edit'))
            @if (session()->get('cannot_edit') == true)
                <div class="alert alert-danger mb-3" role="alert">
                    You cannot edit a deleted item, please restore first!
                </div>
            @endif
        @endif

        <h3> Deleted items </h3>
        <div class='row'>
            <div class="col align-self-end text-right">
                <a class="btn btn-primary btn-lg" href="{{ route('main') }}" role="button">
                    <i class="fas fa-backward"></i><span class="ml-1">Back to main page</span></a>
                <br>
            </div>
        </div>
        <hr>

        <div class="row text-center">
            @forelse ($items as $item)
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
                                @if (Auth::user()->is_admin=='1')
                                    <form action="{{ route('restore.item', ['id' => $item->id]) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-success"><i class="fas fa-trash-restore"></i><span class="ml-1">Restore</span></a>
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
                There are no deleted items.
            </div>
            @endforelse
        </div>

    </div>

@endsection
