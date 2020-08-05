@extends('layouts.app')

@section('content')

<h1 class="title m-b-md">
    Welcome {{ $user->name }}
</h1>
@if ($user_info === null)
<div>
    <p>We have no information about you...</p>
    <p>We require to access atleast to IBAN's user account.</p>
    <a href={{ route('users.create', ['id' => $user->id]) }}>Insert data</a>
@else
<div>
    <h3>Data stored:</h3>
    <p>IBAN: {{ $user_info->iban }}</p>

    @if ($user_info->identity_document !== null)
        <p>Identity Document: {{ $user_info->identity_document }}</p>
    @endif

    @if ($user_info->billing_address !== null)
        <p>Billing Address: {{ $user_info->billing_address }}</p>
    @endif
    <a href={{ route('users.edit', ['id' => $user->id]) }}>Update</a>
    <a href={{ route('home') }}>Go Home</a>
    @endif
</div>
@endsection

