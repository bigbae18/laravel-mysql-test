@extends('layouts.app')

@section('content')
<h1 class="title m-b-md">AdriBank Register</h1>
<div class="form-content">
<form action="register" method="POST">
    @csrf
    <label for="name">
        Name
        <input type="text" id="name" name="name" required>
    </label>
    <label for="surname">
        Surname
        <input type="text" id="surname" name="surname" required>
    </label>
    <label for="email">
        E-mail
        <input type="text" id="email" name="email" required>
    </label>
    <label for="phone">
        Phone
        <input type="text" id="phone" name="phone" required>
    </label>
    <label for="password">
        Password
        <input type="password" name="password" id="password" required>
    </label>
    <label for="repeat_password">
        Repeat password
        <input type="password" name="repeat_password" id="repeat_password" required>
    </label>
    <button class="m-t-md" type="submit">Register</button>
</form>
<div>
@endsection

@section('back-home')
<div class="links m-t-md">
<a href="{{ route('home') }}">Go Home</a>
</div>
@endsection