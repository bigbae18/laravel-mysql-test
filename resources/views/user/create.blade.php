@extends('layouts.app')

@section('content')
<h1 class="title-errors m-b-md">Complete information for {{ $user->name }}</h1>
<div class="form-content">
<form action="{{ route('users.store', ['id' => $user->id]) }}" method="POST">
    @csrf
    <label for="iban">
        IBAN
        <input type="text" id="iban" name="iban" required>
    </label>
    <label for="identity_document">
        Identity Document
        <input type="text" name="identity_document" id="identity_document">
    </label>
    <label for="billing_address">
        Billing Address
        <input type="text" name="billing_address" id="billing_address">
    </label>
    <button type="submit">Send Data</button>
</form>
<div>
@endsection

@section('back-button')
<div class="links m-t-md">
<a href="{{ route('users.index', ['id' => $user->id]) }}">Go Back</a>
</div>
@endsection