<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('https://cdn5.f-cdn.com/contestentries/1578585/21468461/5d62b49ac544b_thumb900.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
        }
        .register-container {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            padding: 30px;
            max-width: 400px;
            margin: 100px auto;
            box-shadow: 0px 4px 20px rgba(0,0,0,0.2);
            backdrop-filter: blur(5px);
        }
        .register-title {
            font-size: 28px;
            font-weight: bold;
            color: #8B2E2E;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-register {
            background-color: #8B2E2E;
            color: white;
            border: none;
        }
        .btn-register:hover {
            background-color: #a94442;
        }
        .register-links {
            text-align: center;
            font-size: 14px;
        }
        .register-links a {
            text-decoration: none;
            color: #8B2E2E;
        }
        .form-control {
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="register-title">Đăng ký</div>

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
        {{-- @php unset($_SESSION['flash']); @endphp --}}
    @endif

    <form action="{{ route('register') }}" method="POST" autocomplete="off">
        @csrf
        <div class="mb-3">
            <input type="text" class="form-control" name="username" placeholder="Tên người dùng" required
                   value="{{ $_POST['username'] ?? '' }}" autocomplete="name">
        </div>
        <div class="mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email" required
                   value="{{ $_POST['email'] ?? '' }}" autocomplete="email">
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" name="password" placeholder="Mật khẩu" required
                   autocomplete="new-password" minlength="6">
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" name="confirm_password" placeholder="Xác nhận mật khẩu" required
                   autocomplete="new-password">
        </div>
        <button type="submit" class="btn btn-register w-100">Register</button>
    </form>

    <div class="register-links mt-3">
        <p>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a></p>
    </div>
</div>

</body>
</html>
