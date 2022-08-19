<div id="table-container" class="table-responsive ">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">name</th>
            <th scope="col">email</th>
            <th scope="col">is_active</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data['users'] as $user)
            <tr>
                <th>{{ $user->id  }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>

                    <div class="form-check form-switch">
                        <input class="form-check-input toggle-active-state"
                               data-user_id="{{ $user->id }}"
                               @if($user->is_active) checked @endif
                               type="checkbox"
                               role="switch">
                    </div>
                </td>

                <td>
                <td>
                    <a href="" class="btn btn-info text-white edit-user" data-bs-toggle="modal"
                       data-user="{{ $user }}"
                       data-bs-target="#edit_modal">Edit</a>
                    <a href="" class="btn btn-danger delete-user" data-user_id="{{ $user->id }}">Delete</a>
                </td>
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
