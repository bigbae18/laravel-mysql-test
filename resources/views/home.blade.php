@extends('layouts.app')

@section('content')
<h1 class="title m-b-md">
    Adri Bank
</h1>
<div class="links">
@auth
<a href="{{ route('users.index', ['id' => Auth::id()]) }}">
    Profile
</a>
<a href="{{ route('logout') }}">
    Logout
</a>
@endauth
@guest
<a href="{{ route('login') }}">
    Login
</a>
<a href="{{ route('register') }}">
    Register
</a>
@endguest
</div>
@endsection
