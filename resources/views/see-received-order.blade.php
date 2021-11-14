@extends('layouts.app')

@section('title', 'My orders')

@section('content')


        <div class="container">
            <div class="row justify-content-center">
            <div class="col-8 align-self-center">
            <div class="jumbotron text-center">

                <h3>Received order with id: {{$order->id}}</h3>
                <br>
                <p><b>Who made the order:</b> </p>
                <ul style="list-style-type: none">
                    <li><b>Name:</b> {{$order->user->name}}</li>
                    <li><b>Email:</b> {{$order->user->email}}</li>
                </ul>
                <p><b>Ordered items and quantities: </b></p>
                <ul style="list-style-type: none">
                    @foreach ($order->ordered_items as $oi)
                        <li style="{{ $oi->item->deleted_at!==null ? 'color: red;' : '' }} ">{{ $oi->item->name }} - {{$oi->quantity}} piece(s)</li>
                    @endforeach
                </ul>
                <p><b>When was it made:</b>
                    {{ $order->received_on }}
                </p>

                <p><b>Total price:</b>
                    @php
                        $sum = 0;
                        foreach ($order->ordered_items as $oi) {
                            $sum += $oi->quantity*$oi->item->price;
                        }
                        echo $sum
                    @endphp
                    $
                </p>
                @if ($order['comment'])
                    <p><b>Comment:</b> {{$order->comment}} </p>
                @endif
                <p><b>Address:</b> {{$order->address}} </p>
                <p><b>Payment method:</b> {{$order->payment_method}} </p>

                @if ($order->status==='RECEIVED')
                    <form action="{{ route('accept-order', ['orderId'=> $order->id ]) }} " method="POST">
                        @csrf
                        <button class="btn btn-success" type="submit">
                            <i class="far fa-check-circle"></i><span class="ml-1">Accept</span></button>
                    </form>
                    <form action="{{ route('reject-order', ['orderId'=> $order->id ]) }}" method="POST">
                        @csrf
                        <button class="btn btn-danger" type="submit">
                            <i class="fas fa-ban"></i><span class="ml-1">Reject</span></button>
                    </form>
                @else
                    <p style="color: green">The order has been processed.</p>
                @endif
                <br><br>
                <a class="btn btn-primary btn-lg" href="{{ route('main') }}" role="button">
                    <i class="fas fa-backward"></i><span class="ml-1">Back to main page</span></a>
                </div>
            </div>
        </div>
    </div>

@endsection
