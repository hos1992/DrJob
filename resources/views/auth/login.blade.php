@extends('app')
@section('content')

    <h1>Login</h1>
    <hr>

    <div class="row">
        <div class="col">
            <h3>Admin Credentials</h3>
            <p>Email : admin@admin.com</p>
            <p>Password : password</p>
        </div>
        <div class="col">
            <h3>User Credentials</h3>
            <p>Email : user@user.com</p>
            <p>Password : password</p>
        </div>
        <div class="col">
            <h3>Super Admin Credentials</h3>
            <p>Email : super@admin.com</p>
            <p>Password : password</p>
        </div>
    </div>
    <hr>
    <div class="error form-error alert alert-danger d-none">

    </div>

    <form id="login_form" action="{{ route('authenticate') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <span class="error error_email">

            </span>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
            <span class="error error_password">

            </span>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="remember_me" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">remember me</label>
        </div>
        <button type="submit" id="submit_button" class="btn btn-primary">Login</button>
    </form>

@stop
@push('script')
    <script>
        $(document).ready(function () {
            $(document).on('submit', '#login_form', function (e) {

                // prevent default behavior
                e.preventDefault();
                //clear errors
                $(document).find('.error').html('');
                $(document).find('.form-error').addClass('d-none');
                // disable submit btn while processing
                $(document).find('#submit_button').attr('disabled', true);

                // make the ajax call
                $.ajax({
                    type: 'post',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: response => {
                        $(document).find('#submit_button').attr('disabled', false);

                        if (response.status) {
                            window.location = response.redirectUrl;
                        } else {
                            $(document).find('.form-error').removeClass('d-none');
                            $(document).find('.form-error').html(response.message);
                        }

                    },
                    error: errors => {
                        $(document).find('#submit_button').attr('disabled', false);
                        for (let error in errors.responseJSON.errors) {
                            $(document).find('[name=' + error + ']').next('span').html(errors.responseJSON.errors[error][0]);
                        }
                    }
                })
            });
        });
    </script>
@endpush
