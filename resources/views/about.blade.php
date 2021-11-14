@extends('layouts.app')

@section('title', 'About')

@section('content')
    <div class="container">
        <div style="background: rgb(175, 238, 238) !important" class="jumbotron">
            <h1 class="display-4">Welcome to FancyOrders!</h1>
            <p class="lead">This application was made by:</p>
            <ul>
                <li>Name: Adrienn Zakariás</li>
                <li>Neptun ID: VUB8VD</li>
                <li>Email: zakarias.adrienn@yahoo.com </li>
            </ul>
            <a class="btn btn-primary btn-lg" href="{{ route('main') }}" role="button">
                <i class="fas fa-backward"></i><span class="ml-1">Back to main page</span></a>
        </div>
    </div>
@endsection
