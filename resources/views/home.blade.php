@extends('layouts.app')

@section('authorized')
<h1 class="title m-b-md">
    Bienvenido Fiera
</h1>
<div class="links">
<a href='#'>
    Añadir info
</a>
</div>
@endsection

@section('not-authorized')
<h1 class="title m-b-md">
    Adri Bank
</h1>
<div class="links">
<a href={{ url('login') }}>
    Login
</a>
<a href={{ url('register') }}>
    Register
</a>
</div>
@endsection
