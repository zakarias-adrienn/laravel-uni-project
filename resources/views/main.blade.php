@extends('layouts.app')

@section('title', 'MainPage')

@section('content')
    <div class="container">
        <div style="background: rgb(175, 238, 238) !important" class="jumbotron">
            <h1 class="display-4">Welcome to FancyOrders!</h1>
            <p class="lead">Here you can see some statistics about the application:</p>
            <hr class="my-4">
            <ul>
                <li>Users: {{ $user_count }}</li>
                <li>Categories: {{ $category_count }}</li>
                <li>Items: {{ $item_count }}</li>
            </ul>
            <div class='row'>
            <div class="col align-self-start">
                <a class="btn btn-primary btn-lg" href="{{ route('items') }}" role="button"><i class="fas fa-search-dollar"></i><span class="ml-1">Browse items</span></a>
                @if (!Auth::guest() && Auth::user()->is_admin=='1')
                    <a class="btn btn-primary btn-lg" href="{{ route('categories') }}" role="button"><i class="far fa-folder-open"></i><span class="ml-1">Categories</span></a>
                @endif
            </div>
            <div class="col align-self-end text-right">
                <a class="btn btn-primary btn-lg" href="{{ route('about') }}" role="button"><i class="far fa-address-card"></i><span class="ml-1">About</span></a>
                @if (!Auth::guest())
                    <a class="btn btn-primary btn-lg" href="{{ route('profile') }}" role="button"><i class="fas fa-user"></i><span class="ml-1">My profile</span></a>
                @endif
                @if (!Auth::guest() && Auth::user()->is_admin=='0')
                    <a class="btn btn-primary btn-lg" href="{{ route('orders') }}" role="button"><i class="fas fa-cash-register"></i><span class="ml-1">My orders</span></a>
                @elseif (!Auth::guest() && Auth::user()->is_admin=='1')
                <a class="btn btn-primary btn-lg" href="{{ route('received.orders') }}" role="button"><i class="fas fa-cash-register"></i><span class="ml-1">Received orders</span></a>
                <a class="btn btn-success btn-lg" href="{{ route('processed.orders') }}" role="button"><i class="fas fa-clipboard-check"></i><span class="ml-1">Processed orders</span></a>
                @endif
            </div>
        </div>
    </div>
@endsection
