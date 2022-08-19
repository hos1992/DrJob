<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <span class="navbar-brand">Dr Job</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                {{--                <li class="nav-item">--}}
                {{--                    <a class="nav-link" href="#">Link</a>--}}
                {{--                </li>--}}

            </ul>
            <ul class="d-flex navbar-nav ">
                <li class="nav-item">
                    <a id="logout" href="" class="nav-link">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@push('script')
    <script>
        $(document).ready(function () {
            $(document).on('click', '#logout', function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'post',
                    url: '/logout',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: response => {
                        if (response.status) {
                            window.location = response.redirectUrl;
                        }
                    }
                });
            });
        });
    </script>
@endpush
