@extends('app')
@section('content')
    <h1> Posts Index ( ajax pagination )</h1>
    <div id="posts">
        <div id="table-container" class="table-responsive ">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">title</th>
                    <th scope="col">content</th>
                    <th scope="col">user</th>
                    <th scope="col">category</th>
                    <th scope="col">status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['posts'] as $post)
                    <tr>
                        <th>{{ $post->id  }}</th>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->content }}</td>
                        <td>{{ $post->user->name ?? '' }}</td>
                        <td>{{ $post->category->name ?? '' }}</td>
                        <td>{{ $post->status }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @if($data['posts']->links())

            <div class="m-2">
                {{ $data['posts']->links() }}
            </div>

        @endif
    </div>

@stop
@push('script')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                let href = $(this).attr('href');
                $.ajax({
                    url: href,
                    success: response => {
                        $(document).find('#posts').html(response);
                    }
                });
            });
        });
    </script>
@endpush
