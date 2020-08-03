@extends('layouts.forms')

@section('form')
<h1 class="title m-b-md">AdriBank Register</h1>
<div class="form-content">
<form action="api/register" method="POST">
    @csrf
    <label for="name">
        Name
        <input type="text" id="name" name="name">
    </label>
    <label for="surname">
        Surname
        <input type="text" id="surname" name="surname">
    </label>
    <label for="email">
        E-mail
        <input type="text" id="email" name="email">
    </label>
    <label for="phone">
        Phone
        <input type="text" id="phone" name="phone">
    </label>
    <label for="password">
        Password
        <input type="password" name="password" id="password">
    </label>
    <button type="submit">Register</button>
</form>
<div>
@endsection