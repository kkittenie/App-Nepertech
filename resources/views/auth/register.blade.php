@extends('layouts.auth')
@section('title', 'Sign Up')

@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card" style="max-width:420px; width:100%;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <a href="{{ route('login') }}" class="mb-4 d-inline-flex align-items-center text-decoration-none">
                    <img src="{{ asset('assets/images/logo-icon.svg') }}" alt="" width="36">
                    <span class="ms-2"><img src="{{ asset('assets/images/logo.svg') }}" alt="" height="20"></span>
                </a>
                <h1 class="card-title mt-3 h5">Create your account</h1>
            </div>

            @if($errors->any())
                <div class="alert alert-danger small py-2">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="needs-validation mt-3" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="fullName" class="form-label">Full name</label>
                    <input id="fullName" name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        placeholder="Jane Doe" value="{{ old('name') }}" required>
                    <div class="invalid-feedback">Please enter your name.</div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="name@example.com" value="{{ old('email') }}" required>
                    <div class="invalid-feedback">Please enter a valid email.</div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Create a password" required minlength="8">
                    <div class="invalid-feedback">Please provide a password (min 8 characters).</div>
                </div>

                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm password</label>
                    <input id="confirmPassword" name="password_confirmation" type="password" class="form-control"
                        placeholder="Repeat password" required>
                    <div class="invalid-feedback">Passwords must match.</div>
                </div>

                <div class="mb-3 form-check">
                    <input id="terms" name="terms" class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" required value="1">
                    <label class="form-check-label small" for="terms">
                        I agree to the <a href="#" class="text-decoration-none link-primary">terms and privacy</a>
                    </label>
                    <div class="invalid-feedback">You must agree before continuing.</div>
                </div>

                <button class="btn btn-primary w-100" type="submit">Sign up</button>
            </form>

            <div class="text-center mt-3 small text-muted">
                Already have an account? <a href="{{ route('login') }}" class="link-primary">Sign in</a>
            </div>
        </div>
    </div>
</div>
@endsection