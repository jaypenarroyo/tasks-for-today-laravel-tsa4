@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="page-header" style="justify-content: center; text-align: center;">
        <div>
            <p class="page-eyebrow">Laravel Breeze Authentication</p>
            <h1 class="page-title">Create Account</h1>
            <p class="page-subtitle">Register to manage tasks in Tasks for Today.</p>
        </div>
    </div>

    <section class="card card-narrow">
        <div class="card-body">
            @if ($errors->any())
                <div class="error-banner" role="alert">
                    <strong>Please fix the following errors:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input
                        id="username"
                        name="username"
                        type="text"
                        class="form-control"
                        value="{{ old('username') }}"
                        required
                        autofocus
                        autocomplete="username"
                    >
                </div>

                <div class="form-group">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input
                        id="full_name"
                        name="full_name"
                        type="text"
                        class="form-control"
                        value="{{ old('full_name') }}"
                        required
                        autocomplete="name"
                    >
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
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
                        autocomplete="new-password"
                    >
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        class="form-control"
                        required
                        autocomplete="new-password"
                    >
                </div>

                <div class="form-actions" style="justify-content: space-between;">
                    <a href="{{ route('login') }}" style="font-size: 0.88rem;">Already registered? Log in</a>
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </section>
@endsection
