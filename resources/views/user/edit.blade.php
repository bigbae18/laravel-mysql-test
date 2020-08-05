@extends('layouts.app')

@section('content')
<h1 class="title-errors m-b-md">Complete information for {{ $user->name }}</h1>
<div class="form-content">
<form action="{{ route('users.update', ['id' => $user->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="iban">
        IBAN
        <input type="text" id="iban" name="iban" value="{{$user_info->iban}}" required>
    </label>
    
    <label for="identity_document">
        Identity Document
        @if ($user_info->identity_document === null)
            <input type="text" name="identity_document" id="identity_document">
        @else
            <input type="text" name="identity_document" id="identity_document" value="{{$user_info->identity_document}}" disabled>
        @endif
    </label>
    <label for="billing_address">
        Billing Address
        @if ($user_info->billing_address === null)
            <input type="text" name="billing_address" id="billing_address">
        @else
            <input type="text" name="billing_address" id="billing_address" value="{{$user_info->billing_address}}">
        @endif
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