<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width: 500px;">
    <h2 class="mb-4">Đăng nhập</h2>

    @php
        if (!empty($_SESSION['flash'])) {
            foreach ($_SESSION['flash'] as $type => $msg) {
                echo "<div class='alert alert-$type'>$msg</div>";
            }
            unset($_SESSION['flash']);
        }
    @endphp

    <form action="{{ route('login') }}" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Địa chỉ email</label>
            <input type="email" class="form-control" name="email" required value="{{ $_POST['email'] ?? '' }}">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
    </form>
    <p class="mt-3 text-center">Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a></p>
</div>
</body>
</html>
