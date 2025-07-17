<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    {{-- Header --}}
    @include('Staff.partials.header')

    {{-- Main layout --}}
    <div class="container-fluid">
        <div class="row">

            {{-- Sidebar chiếm 2/12 --}}
            <div class="col-md-2 bg-light min-vh-100 p-3 border-end">
                @include('Staff.partials.aside')
            </div>

            {{-- Nội dung chính chiếm 10/12 --}}
            <div class="col-md-10 p-4">
                @yield('content')
            </div>

        </div>
    </div>

    {{-- Footer --}}
    <div class="bg-dark text-white text-center py-3 mt-4">
        @include('Staff.partials.footer')
    </div>

</body>
</html>
