@extends('layouts.forms')

@section('form')
<h1 class="title m-b-md">AdriBank Login</h1>
<div class="form-content">
<form action="api/login" method="POST">
    @csrf
    <label for="email">
        E-mail
        <input type="text" id="email" name="email">
    </label>
    <label for="password">
        Password
        <input type="password" name="password" id="password">
    </label>
    <button type="submit">Login</button>
</form>
<div>
@endsection