@extends('layouts.app')

@section('content')
<h1 class="title m-b-md">AdriBank Login</h1>
<div class="form-content">
<form action="login" method="POST">
    @csrf
    <label for="email">
        E-mail
        <input type="text" id="email" name="email" required>
    </label>
    <label for="password">
        Password
        <input type="password" name="password" id="password" required>
    </label>
    <button class="m-t-md" type="submit">Login</button>
</form>
<div>
@endsection

@section('back-home')
<div class="links m-t-md">
<a href="{{ route('home') }}">Go Home</a>
</div>
@endsection