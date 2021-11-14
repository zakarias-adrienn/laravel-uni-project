@extends('layouts.app')

@section('title', 'My orders')

@section('content')

    <div class="container">

        <h3>My orders</h3>
        <br>
        <div class="row">
            <table class="table table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ordered items - quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <ul>
                                @foreach ($order->ordered_items as $oi)
                                    <li style="{{ $oi->item->deleted_at!==null ? 'color: red;' : '' }} ">{{ $oi->item->name }} - {{$oi->quantity}}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @php
                                $sum = 0;
                                foreach ($order->ordered_items as $oi) {
                                    $sum += $oi->quantity*$oi->item->price;
                                }
                                echo $sum
                            @endphp
                            $
                        </td>
                        <td>{{ $order->status }}</td>
                    </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">You have not ordered anything yet.</td></tr>
                    @endforelse
                </tbody>
              </table>
        </div>

        <a class="btn btn-primary btn-lg" href="{{ route('main') }}" role="button">
            <i class="fas fa-backward"></i><span class="ml-1">Back to main page</span></a>

    </div>

@endsection
