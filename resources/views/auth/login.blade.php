
@extends('layouts.app')
@section('content')
<div class="login-card">
    <h4 class="text-center mb-4">Login to Your Account</h4>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label text-white">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label text-white">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label text-white" for="remember">Remember Me</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>
@endsection
