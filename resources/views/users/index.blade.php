@extends('app')
@section('content')
    <div class="row">
        <div class="col">
            <h1> Users Index ( ajax pagination )</h1>
        </div>
        <div class="col">
            <a href="/users/create" class="btn btn-primary float-end">Add New</a>
        </div>
    </div>
    <div id="users">
        <div id="table-container" class="table-responsive ">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">name</th>
                    <th scope="col">email</th>
                    <th scope="col">is active</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['users'] as $user)
                    <tr>
                        <th>{{ $user->id  }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">
                            <div class="form-check form-switch ">
                                <input class="form-check-input toggle-active-state"
                                       data-user_id="{{ $user->id }}"
                                       @if($user->is_active) checked @endif
                                       type="checkbox"
                                       role="switch">
                            </div>

                        </td>
                        <td>
                            <a href="" class="btn btn-info text-white edit-user" data-bs-toggle="modal"
                               data-user="{{ $user }}"
                               data-bs-target="#edit_modal">Edit</a>
                            <a href="" class="btn btn-danger delete-user" data-user_id="{{ $user->id }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @if($data['users']->links())

            <div class="m-2">
                {{ $data['users']->links() }}
            </div>

        @endif
    </div>


    <!-- Button trigger modal -->
    <div id="edit_modal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close close-edit-form" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="error form-error alert alert-danger d-none">

                    </div>

                    <form id="edit_form" action="#" method="post">
                        @csrf
                        {{ method_field('put') }}

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
                            <input type="password" name="password_confirmation" class="form-control"
                                   id="exampleInputPassword2">
                            <span class="error">

                            </span>
                        </div>
                        <button type="submit" id="submit_button" class="btn btn-primary">Save</button>
                    </form>

                </div>

            </div>
        </div>
    </div>

@stop
@push('script')
    <script>
        $(document).ready(function () {

            // paginated index
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                let href = $(this).attr('href');
                window.history.pushState('users', 'Index', href);
                $.ajax({
                    url: href,
                    success: response => {
                        $(document).find('#users').html(response);
                    }
                });
            });

            // toggle user active state
            $(document).on('change', '.toggle-active-state', function (e) {

                $.ajax({
                    type: 'post',
                    url: "{{ route('users.toggle-active-state') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        'user_id': $(this).data('user_id'),
                    },
                    success: response => {
                        if (response.status) {
                            setTimeout(function () {
                                alert('User Active State Changed Successfully ');
                            }, 100);
                        }
                    },

                });
            });

            // open edit modal
            $(document).on('click', '.edit-user', function (e) {
                e.preventDefault();

                $(document).find('#edit_form [name=name]').val('');
                $(document).find('#edit_form [name=email]').val('');
                $(document).find('#edit_form [name=password]').val('');
                $(document).find('#edit_form [name=password_confirmation]').val('');

                let user = $(this).data('user');
                $(document).find('#edit_form').attr('action', '/users/' + user.id);
                $(document).find('#edit_form [name=name]').val(user.name);
                $(document).find('#edit_form [name=email]').val(user.email);
            });

            // submit edit form
            $(document).on('submit', '#edit_form', function (e) {
                e.preventDefault();
                //clear errors
                $(document).find('.error').html('');
                $(document).find('.form-error').addClass('d-none');
                // disable submit btn while processing
                $(document).find('#submit_button').attr('disabled', true);

                $.ajax({
                    type: 'post',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: response => {
                        $(document).find('#submit_button').attr('disabled', false);

                        if (response.status) {
                            $(document).find('.close-edit-form').click();
                            $.ajax({
                                url: window.location.href,
                                success: response => {
                                    $(document).find('#users').html(response);
                                }
                            });
                        }
                    },
                    error: errors => {
                        $(document).find('#submit_button').attr('disabled', false);
                        for (let error in errors.responseJSON.errors) {
                            $(document).find('[name=' + error + ']').next('span').html(errors.responseJSON.errors[error][0]);
                        }
                    }
                });

            });

            // delete user
            $(document).on('click', '.delete-user', function (e) {
                e.preventDefault();
                let userId = $(this).data('user_id');

                if (confirm('Are you sure you want to delete the user ' + userId)) {
                    $.ajax({
                        type: 'post',
                        url: "/users/" + userId,
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "delete",
                        },
                        success: response => {
                            if (response.status) {
                                $.ajax({
                                    url: window.location.href,
                                    success: response => {
                                        $(document).find('#users').html(response);
                                    }
                                });
                            }
                        }
                    });
                }


            });
        });
    </script>
@endpush
