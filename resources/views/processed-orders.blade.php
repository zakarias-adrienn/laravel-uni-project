@extends('layouts.app')

@section('title', 'My orders')

@section('content')

    <div class="container">

        <h3>Processed orders</h3>
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
                        <tr><td colspan="4" class="text-center">There are no processed orders.</td></tr>
                    @endforelse
                </tbody>
              </table>
        </div>

        <a class="btn btn-primary btn-lg" href="{{ route('main') }}" role="button">
            <i class="fas fa-backward"></i><span class="ml-1">Back to main page</span></a>

    </div>

@endsection
