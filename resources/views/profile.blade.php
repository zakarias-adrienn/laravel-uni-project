@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="container">
        <div style="background: rgb(175, 238, 238) !important" class="jumbotron">
            <h1 class="display-4">Welcome, {{ Auth::user()->name }} !</h1>
            <ul style='list-style-type: none !important'>
                <li><i class="fas fa-user-alt"></i><span class="ml-1"><u>Name:</u> {{ Auth::user()->name }} </span></li>
                <li><i class="fas fa-envelope"></i><span class="ml-1"><u>Email:</u> {{ Auth::user()->email }} </span></li>
                <li><i class="fas fa-user-tag"></i><span class="ml-1"><u>Role:</u> {{ Auth::user()->is_admin ? 'admin' : 'user' }}</span> </li>
            </ul>
            <a class="btn btn-primary btn-lg" href="{{ route('main') }}" role="button">
                <i class="fas fa-backward"></i><span class="ml-1">Back to main page</span></a>
        </div>
    </div>
@endsection
