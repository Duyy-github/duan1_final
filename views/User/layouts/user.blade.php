<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .content-wrapper {
            min-height: 1200px;
        }
    </style>
</head>

<body>
    

    {{-- Header --}}
    @include('User.partials.header')

    {{-- Main layout --}}
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 content-wrapper">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="bg-dark text-white text-center py-3 mt-4">
        @include('User.partials.footer')
    </div>

</body>
@stack('scripts')

</html>