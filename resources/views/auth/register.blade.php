@extends('layouts.auth')

@push('css-styles')
<style>
</style>
@endpush

@section('content')
<div class="card card-primary">
    <div class="card-header"><h4>Register</h4></div>

    <div class="card-body">
    <!-- form start -->
    <form id="form-register" method="POST" action="/register">

        <div class="row">
            <div class="col-md-12">
                <p id="alert-success" class="alert alert-success d-none">Registered successfully!</p>
                <p id="alert-danger" class="alert alert-danger d-none"></p>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label for="name">Name</label>
                <input id="name" type="text" class="form-control" name="name" autofocus>
                <p id="alert-name" class="alert alert-danger mt-3 d-none"></p>
            </div>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" class="form-control" name="email">
            <p id="alert-email" class="alert alert-danger mt-3 d-none"></p>
        </div>

        <div class="row">
            <div class="form-group col-6">
                <label for="password" class="d-block">Password</label>
                <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password">
                <div id="pwindicator" class="pwindicator">
                <div class="bar"></div>
                <div class="label"></div>
                </div>
            </div>
            <div class="form-group col-6">
                <label for="password2" class="d-block">Confirmation</label>
                <input id="password2" type="password" class="form-control" name="password_confirmation">
            </div>
            <div class="form-group col-12">
                <p id="alert-password" class="alert alert-danger d-none"></p>
            </div>
        </div>

        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                <label class="custom-control-label" for="agree">I agree with the terms and conditions</label>
            </div>
            <p id="alert-agreement" class="alert alert-danger mt-3 d-none">Please check the agreement before continue</p>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block">
                Register
            </button>
        </div>

    </form>
    <!-- form end -->
    </div>

</div>

<div class="mt-5 text-muted text-center">
    Already have an account? <a href="/login">Sign In</a>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$('#form-register').submit(function(e) {
    e.preventDefault();
    $('.alert').hide();
    if(!$('input[name="agree"]').is(':checked')) {
        $('#alert-agreement').removeClass('d-none').fadeIn('slow');
        return false;
    }
    let formData = new FormData($(this)[0]);
    let config = { method: 'post', url: domain + 'register', data: formData };
    axios(config)
    .then((response) => {
        $('#alert-success').removeClass('d-none').html(response.data.message).fadeIn('slow');
        window.location.href = "/login?success=Registered successfully";
    })
    .catch((error) => {
        console.log(error.response);
        if(error.response.data.errors) {
            if(error.response.data.errors.name) { $('#alert-name').html(error.response.data.errors.name).removeClass('d-none').hide().fadeIn('slow'); }
            if(error.response.data.errors.email) { $('#alert-email').html(error.response.data.errors.email).removeClass('d-none').hide().fadeIn('slow'); }
            if(error.response.data.errors.password) { $('#alert-password').html(error.response.data.errors.password).removeClass('d-none').hide().fadeIn('slow'); }
        }
    });
});
</script>
@endpush