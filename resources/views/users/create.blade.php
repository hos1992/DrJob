@extends('app')
@section('content')

    <div id="users-wrapper">
        <h1>Create New User</h1>

        <div class="error form-error alert alert-danger d-none">

        </div>

        <form id="form" action="{{ route('users.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="exampleInputName" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="exampleInputName">
                <span class="error">

            </span>
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                       aria-describedby="emailHelp">
                <span class="error">

            </span>
            </div>


            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                <span class="error">

            </span>
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword2" class="form-label">Password Confirmation</label>
                <input type="password" name="password_confirmation" class="form-control" id="exampleInputPassword2">
                <span class="error">

            </span>
            </div>
            <button type="submit" id="submit_button" class="btn btn-primary">Save</button>
        </form>

    </div>

@stop
@push('script')
    <script>
        $(document).ready(function () {
            $(document).on('submit', '#form', function (e) {

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
