@extends('app')
@section('content')

    <h1 class="text-center m-5">
        Super Admin Home Page
    </h1>

    <div class="row">
        <div class="col text-center">
            <a href="{{ route('users.index') }}" class="btn btn-primary btn-lg">
                Users
            </a>
        </div>
        <div class="col text-center">
            <a href="{{ route('posts.index') }}" class="btn btn-primary  btn-lg">
                Posts
            </a>
        </div>
    </div>

@stop
