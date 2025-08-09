@extends('User.layouts.user')

@section('content')

@if(isset($_SESSION['success']))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ $_SESSION['success'] }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @php unset($_SESSION['success']); @endphp
@endif

{{-- Hero Section --}}
<section class="text-center py-5 mb-5 bg-light rounded shadow-sm" style="background: url('{{ asset('images/banner.jpg') }}') center/cover no-repeat;">
    <div class="container text-white" style="background-color: rgba(0,0,0,0.5); padding: 50px; border-radius: 10px;">
        <h1 class="display-4 fw-bold">Khám phá thế giới công nghệ</h1>
        <p class="lead">Những sản phẩm mới nhất, hiện đại nhất đang chờ bạn.</p>
        <a href="#products" class="btn btn-primary btn-lg mt-3 px-4 py-2">
            <i class="bi bi-cart4"></i> Mua ngay
        </a>
    </div>
</section>

{{-- Top sản phẩm mới ra mắt --}}
<section class="mb-5">
    <h2 class="mb-4 text-primary fw-bold"><i class="bi bi-stars"></i> Top 10 sản phẩm mới ra mắt</h2>
    <div class="row">
        @foreach($topProducts as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 border-0 shadow-sm product-card transition">
                    <img src="{{ asset($product['image']) }}" class="card-img-top" alt="{{ $product['product_name'] }}"
                         style="height: 180px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product['product_name'] }}</h5>
                        <p class="card-text text-danger fw-bold">{{ number_format($product['price'], 0, '', ',') }} đ</p>
                        <a href="{{ route('user/products/show/' . $product['product_id']) }}"
                           class="btn btn-outline-info w-100 mt-auto">
                            <i class="bi bi-eye"></i> Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<hr class="mb-5">

{{-- Danh sách tất cả sản phẩm --}}
<section id="products">
    <h2 class="mb-4 text-success fw-bold"><i class="bi bi-box-seam"></i> Tất cả sản phẩm</h2>
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 border-0 shadow-sm product-card transition">
                    <img src="{{ asset($product['image']) }}" class="card-img-top" alt="{{ $product['product_name'] }}"
                         style="height: 180px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product['product_name'] }}</h5>
                        <p class="card-text text-danger fw-bold">{{ number_format($product['price'], 0, '', ',') }} đ</p>
                        <a href="{{ route('user/products/show/' . $product['product_id']) }}"
                           class="btn btn-outline-success w-100 mt-auto">
                            <i class="bi bi-eye"></i> Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

@endsection

@push('styles')
<style>
    .product-card {
        transition: all 0.3s ease-in-out;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
</style>
@endpush
