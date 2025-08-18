<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('user') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height:40px;" class="me-2">
            Trang chủ
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Danh mục
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                        {{-- @foreach($categories as $category)
                            <li>
                                <a class="dropdown-item" href="{{ route('user/products', ['category' => $category['category_id']]) }}">
                                    {{ $category['category_name'] }}
                                </a>
                            </li>
                        @endforeach --}}
                    </ul>
                </li>
            </ul>

            <form class="d-flex me-3" action="{{ route('user/products') }}" method="GET">
                <input class="form-control me-2" type="search" name="search" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Tìm</button>
            </form>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user/cart') }}">
                        <i class="bi bi-cart"></i> Giỏ hàng
                    </a>
                </li>

                @if (isset($_SESSION['user']))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user/orders') }}">
                            <i class="bi bi-receipt-cutoff"></i> Theo dõi đơn hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            👋 Xin chào, {{ $_SESSION['user']['name'] }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Đăng xuất</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Đăng ký</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
