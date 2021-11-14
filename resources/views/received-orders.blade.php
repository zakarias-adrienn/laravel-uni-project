@extends('layouts.app')

@section('title', 'My orders')

@section('content')

    <div class="container">

        @if (session()->has('order_accepted'))
            @if (session()->get('order_accepted') == true)
                <div class="alert alert-success mb-3" role="alert">
                    You successfully accepted an order!
                </div>
            @endif
        @endif

        @if (session()->has('order_rejected'))
            @if (session()->get('order_rejected') == true)
                <div class="alert alert-danger mb-3" role="alert">
                    You rejected an order!
                </div>
            @endif
        @endif

        <h3>Received orders</h3>
        <br>
        <div class="row">
            <table class="table table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Orders (Click on them to see details)</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('see-order', ['id' => $order->id]) }}">Order number {{ $loop->iteration }}.</a></td>
                    </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">There are no received orders.</td></tr>
                    @endforelse
                </tbody>
              </table>
        </div>

        <a class="btn btn-primary btn-lg" href="{{ route('main') }}" role="button">
            <i class="fas fa-backward"></i><span class="ml-1">Back to main page</span></a>

    </div>

@endsection
