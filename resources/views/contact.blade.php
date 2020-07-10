@extends('layout')

@section('content')
    <h1>Contact Page</h1>
    <p>This is the content of the contact page.</p>

    @can('home.secret')
        <p>
            <a href={{ route('secret') }}>Some special contact details</a>
        </p>
    @endcan

@endsection
