@extends('layouts.auth')

@push('css-styles')
<style>
</style>
@endpush

@section('content')
<div class="card card-primary">
    <div class="card-header"><h4>Login</h4></div>

    <div class="card-body">

    <!-- form start -->
    <form id="form-login" method="POST" action="/login" class="needs-validation" novalidate="">
        @csrf

        <div class="form-group">
            @if(isset($_GET['success']))
            <p id="alert-success" class="alert alert-success">{{$_GET['success']}}</p>
            @endif
            @if(session('error'))
            <p id="alert-danger" class="alert alert-danger">{{ session('error') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
            <div class="invalid-feedback">
                Please fill in your email
            </div>
        </div>

        <div class="form-group">
            <div class="d-block">
                <label for="password" class="control-label">Password</label>
                <div class="float-right">
                <a href="auth-forgot-password.html" class="text-small">
                    Forgot Password?
                </a>
                </div>
            </div>
            <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
            <div class="invalid-feedback">
                please fill in your password
            </div>
        </div>

        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                <label class="custom-control-label" for="remember-me">Remember Me</label>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                Login
            </button>
        </div>

    </form>
    <!-- form end -->

    </div>
</div>
<div class="mt-5 text-muted text-center">
    Don't have an account? <a href="/register">Create One</a>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
</script>
@endpush