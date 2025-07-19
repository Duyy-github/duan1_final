@extends('Staff.layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Chi tiết sản phẩm</h1>
    <div class="card mb-3" style="max-width: 700px;">
        <div class="row g-0">
            <div class="col-md-4 d-flex align-items-center justify-content-center">
                @if ($product['image'])
                    <img src="{{ $product['image'] }}" class="img-fluid rounded" alt="{{ $product['product_name'] }}">
                @else
                    <span class="text-muted">No image</span>
                @endif
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h4 class="card-title">{{ $product['product_name'] }}</h4>
                    <p class="card-text mb-2"><strong>Giá:</strong> {{ number_format($product['price'], 0, '', ',') }} đ</p>
                    <p class="card-text mb-2"><strong>Số lượng:</strong> {{ $product['quantity'] }}</p>
                    <p class="card-text mb-2"><strong>Danh mục:</strong> {{ $product['category_name'] ?? 'Không có' }}</p>
                    <p class="card-text mb-2"><strong>Ngày nhập:</strong> {{ $product['import_date'] }}</p>
                    <p class="card-text mb-2"><strong>Mô tả:</strong> {{ $product['description'] }}</p>
                    <a href="{{ route('staff/products') }}" class="btn btn-secondary mt-3">
                        <i class="bi bi-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
