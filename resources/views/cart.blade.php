@extends('layouts.app')

@section('title', 'All items on cart')

@section('content')

    <div class="container">

        @if (session()->has('item_deleted'))
            <div class="alert alert-success mb-3" role="alert">
                You have successfully deleted the following item: {{ session()->get('item_deleted') }}
            </div>
        @endif

        <h3>Right now these items are in your bag: </h3>
        <div class="text-right my-3">
            <a href="{{ route('items') }}" role="button" class="btn btn-primary">
                <i class="fas fa-backward"></i><span class="ml-1">Back to items</span></a>
        </div>
        <br>
        <div class="row">
            <table class="table table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Item name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        @forelse ($order->ordered_items as $oi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $oi->item->name }}</td>
                            <td>{{ $oi->item->price }} $</td>
                            <td>{{ $oi->quantity }} </td>
                            <td>
                                <form action=" {{ route('remove.cart', ['itemId' => $oi->item->id] ) }} " method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="far fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">There are no items in the bag yet.</td></tr>
                        @endforelse
                    @empty
                        <tr><td colspan="5" class="text-center">There are no items in the bag yet.</td></tr>
                    @endforelse
                </tbody>
              </table>

        </div>

        <div class="alert alert-info text-center" role="alert">
            Total price:
                @php
                    $sum = 0;
                    foreach($orders as $order){
                        foreach($order->ordered_items as $oi){
                            $sum += $oi->quantity*$oi->item->price;
                        }
                    };
                    print($sum);
                @endphp
                $
        </div>

        <div class="container">
            <div class="row justify-content-center">
            <div class="col-md-4 col-md-offset-6 centered">
                <h3 style="text-align: center;">Complete the order!</h3>
                <form action="{{ route('send.cart') }}" method="POST">
                    @csrf

                    <div class="form-group row">
                    <label for="address" class="col-form-label">Address</label>
                        <input type="text" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="address" name="address" placeholder="Enter address"
                            value="{{ old('address') }}">
                            @if ($errors->has('address'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </div>
                            @endif
                    </div>

                    <div class="form-group row">
                    <label for="comment" col="col-form-label">Comment</label>
                    <textarea id="comment" name="comment" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="form-group row">
                    Payment method:
                        &nbsp;
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="payment_method_1" value="CARD" checked>
                        <label class="form-check-label" for="payment_method_1">
                        Card
                        </label>
                    </div>
                    &nbsp;
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="payment_method_2" value="CASH">
                        <label class="form-check-label" for="payment_method_2">
                        Cash
                        </label>
                    </div>
                        @if ($errors->has('payment_method'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('payment_method') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary" <?php if ($sum == 0){ ?> disabled <?php   } ?> >
                            <i class="fas fa-gifts"></i><span class="ml-1">Finalize order</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div>

@endsection
