@extends('Staff.layouts.admin')

@section('content')
    <h1>Danh sách sản phẩm</h1>

    {{-- Hiển thị lỗi --}}
    @php
        if (!empty($_SESSION['flash'])) {
            foreach ($_SESSION['flash'] as $type => $msg) {
                echo "<div class='alert alert-$type'>$msg</div>";
            }
            unset($_SESSION['flash']);
        }
    @endphp

    <div class="mb-3 text-end">
        <a href="{{ route('products/create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Thêm sản phẩm
        </a>
    </div>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>STT</th>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Danh mục</th>
                <th>Ngày nhập</th>
                <th>Số lượng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if ($product['image'])
                            <img src="{{ $product['image'] }}" alt="{{ $product['product_name'] }}" class="img-thumbnail" style="max-width: 80px;">
                        @else
                            <small>No image</small>
                        @endif
                    </td>
                    <td>{{ $product['product_name'] }}</td>
                    <td>{{ number_format($product['price'], 0, '', ',') }} đ</td>
                    <td>{{ $product['category_name'] ?? 'Không có' }}</td>
                    <td>{{ $product['import_date'] }}</td>
                    <td>{{ $product['quantity'] }}</td>
                    <td>
                        <a href="{{ route('products/show/' . $product['product_id']) }}" class="btn btn-sm btn-info me-1">
                            <i class="bi bi-eye"></i> Xem
                        </a>
                        <a href="{{ route('products/edit/' . $product['product_id']) }}" class="btn btn-sm btn-danger me-1">
                            <i class="bi bi-pencil-square"></i> Sửa
                        </a>
                        <form action="{{ route('products/' . $product['product_id'] . '/destroy') }}" method="POST"
                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')" style="display:inline-block;">
                            @csrf
                            <button class="btn btn-sm btn-warning me-1" type="submit">
                                <i class="bi bi-trash"></i> Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
