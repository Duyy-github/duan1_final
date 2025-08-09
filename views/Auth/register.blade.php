<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="mb-4">Đăng ký tài khoản</h2>

        @if(isset($_SESSION['flash']))
            @foreach($_SESSION['flash'] as $type => $messages)
                <div class="alert alert-{{ $type === 'success' ? 'success' : 'danger' }}">
                    @if(is_array($messages))
                        @foreach($messages as $message)
                            <p>{{ $message }}</p>
                        @endforeach
                    @else
                        <p>{{ $messages }}</p>
                    @endif
                </div>
            @endforeach
            @php unset($_SESSION['flash']); @endphp
        @endif

        <form action="{{ route('register') }}" method="POST" autocomplete="off">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Họ tên</label>
                <input type="text" class="form-control" id="username" name="username" required
                    value="{{ $_POST['username'] ?? '' }}" autocomplete="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Địa chỉ email</label>
                <input type="email" class="form-control" id="email" name="email" required
                    value="{{ $_POST['email'] ?? '' }}" autocomplete="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" required
                    autocomplete="new-password" minlength="6">
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Nhập lại mật khẩu</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required
                    autocomplete="new-password">
            </div>
            <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
        </form>
        <p class="mt-3 text-center">Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a></p>
    </div>
</body>

</html>