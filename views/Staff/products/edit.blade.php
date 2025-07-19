@extends('Staff.layouts.admin')

@section('content')
    <div class="container" style="max-width: 600px;">
        <h2 class="mb-4">Cập nhật sản phẩm</h2>
        {{-- Hiển thị lỗi --}}
        @if (isset($_SESSION['flash']['error']))
            <div class='alert alert-danger'>
                {{$_SESSION['flash']['error']}}
            </div>
            <?php unset($_SESSION['flash']) ?>
        @endif
        <form action="{{ route('staff/products/update/'. $product['product_id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="product_name" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product['product_name'] }}" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Ảnh sản phẩm</label>
                @if (!empty($product['image']))
                    <div class="mb-2">
                        <img src="/storage/products/{{ $product['image'] }}" alt="Ảnh sản phẩm" style="max-width:100px;">
                    </div>
                @endif
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" class="form-control" id="price" name="price" min="0" value="{{ $product['price'] }}" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Số lượng</label>
                <input type="number" class="form-control" id="quantity" name="quantity" min="0" value="{{ $product['quantity'] }}" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category['category_id'] }}" {{ $product['category_id'] == $category['category_id'] ? 'selected' : '' }}>
                            {{ $category['category_name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ $product['description'] }}</textarea>
            </div>
            <div class="mb-3">
                <label for="import_date" class="form-label">Ngày nhập</label>
                <input type="date" class="form-control" id="import_date" name="import_date" value="{{ $product['import_date'] }}" required>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Cập nhật sản phẩm</button>
            <a href="{{ route('staff/products') }}" class="btn btn-secondary ms-2">Quay lại</a>
        </form>
    </div>
@endsection