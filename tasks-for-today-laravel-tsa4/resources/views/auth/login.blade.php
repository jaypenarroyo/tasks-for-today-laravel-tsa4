@extends('layouts.app')

@section('title', 'Log In')

@section('content')
    <div class="page-header" style="justify-content: center; text-align: center;">
        <div>
            <p class="page-eyebrow">Laravel Breeze Authentication</p>
            <h1 class="page-title">Log In</h1>
            <p class="page-subtitle">Sign in to create, edit, and archive tasks.</p>
        </div>
    </div>

    <section class="card card-narrow">
        <div class="card-body">
            @if ($errors->any())
                <div class="error-banner" role="alert">
                    <strong>Unable to sign in:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="form-control"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <div class="form-group">
                    <label class="checkbox-row">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                </div>

                <div class="form-actions" style="justify-content: space-between;">
                    <a href="{{ route('register') }}" style="font-size: 0.88rem;">Need an account? Register</a>
                    <button type="submit" class="btn btn-primary">Log In</button>
                </div>
            </form>
        </div>
    </section>
@endsection
