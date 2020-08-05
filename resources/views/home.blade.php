@extends('layouts.app')

@section('content')
<h1 class="title m-b-md">
    Adri Bank
</h1>
<div class="links">
@auth
<a href={{ route('users.show', ['id' => Auth::id()]) }}>
    Profile
</a>
@endauth
@guest
<a href={{ route('login.get') }}>
    Login
</a>
@endguest
</div>
@endsection
