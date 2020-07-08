@extends('layout')

@section('content')

    <form method="POST" action={{ route('register') }}>
        @csrf

        <div class="form-group">
            <label>Name</label>
            <input
                required
                name="name"
                value="{{ old('name') }}"
                class="form-control {{ $errors->has("name") ? 'is-invalid' : '' }}"
            >
            @if ($errors->has('name'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>E-mail</label>
            <input
                required
                name="email"
                value="{{ old('email') }}"
                class="form-control {{ $errors->has("email") ? 'is-invalid' : '' }}"
            >
            @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>Password</label>
            <input
                required
                name="password"
                type="password"
                class="form-control {{ $errors->has("password") ? 'is-invalid' : '' }}"
            >
            @if ($errors->has('password'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required class="form-control">
        </div>

        <button type="submit" class="btn btn-primary btn-block">Register!</button>

    </form>

@endsection
