@extends('layouts.app')

@section('content')
<h1 class="title m-b-md">Welcome {{ $user->name }}</h1>
<div class="user-info-content links">
    @if ($user_info === null)
        <p>We have no information about you as User...</p>
        <p>We require to access atleast to IBAN's user account.</p>
        <a href={{ route('users.info.edit', ['id' => $user->id]) }}>Insert data</a>
    @else
        <p>Data stored:</p>
        <ul>
            <li>IBAN: {{ $user_info->iban }}</li>
            @if ($user_info->identity_document !== null)
            <li>Identity Document: {{ $user_info->identity_document }}</li>
            @endif
            @if ($user_info->billing_address !== null)
            <li>Billing Address: {{ $user_info->billing_address }}
            @endif
        </ul>
        <a href={{ route('users.info.edit', ['id' => $user->id]) }}>Update data</p>
    @endif
    <a href={{ route('home') }}>Go Home</a>
</div>
@endsection

@section('user-info-content')



@endsection