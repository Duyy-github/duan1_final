@extends('User.layouts.user')

@section('content')

    {{-- @php
    if (!isset($_SESSION['user'])) {
    header('Location: ' . route('login'));
    exit;
    }
    @endphp --}}

    <div class="container py-4">
        <div class="row bg-white rounded shadow-sm p-4 mb-4">
            {{-- Ảnh sản phẩm và ảnh nhỏ --}}
            <div class="col-md-5">
                <div class="mb-3 text-center">
                    <img src="{{ asset($product['image']) }}" class="img-fluid rounded border"
                        alt="{{ $product['product_name'] }}" style="max-height:320px;object-fit:contain;">
                </div>
            </div>
            {{-- Thông tin sản phẩm --}}
            <div class="col-md-7">
                <h3 class="fw-bold mb-2">{{ $product['product_name'] }}</h3>
                <div class="mb-3">
                    <span class="fs-4 text-danger fw-bold">{{ number_format($product['price'], 0, '', ',') }} đ</span>
                </div>
                <div class="mb-3">
                    <span class="me-3"><strong>Số lượng trong kho:</strong> {{ $product['quantity'] }}</span>
                </div>
                <form action="{{ route('user/cart/add/' . $product['product_id']) }}" method="POST" class="mb-3">
                    @csrf
                    <div class="mb-3 d-flex align-items-center">
                        <label for="quantity" class="form-label me-2 mb-0"><strong>Số lượng:</strong></label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1"
                            style="width:80px;">
                    </div>
                    <button type="submit" class="btn btn-success px-5 py-2 fs-5">
                        <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                    </button>
                </form>
            </div>
        </div>

        {{-- Mô tả và thông tin chi tiết --}}
        <div class="row bg-white rounded shadow-sm p-4">
            <div class="col-12 mb-4">
                <h4 class="mb-3">Mô tả sản phẩm</h4>
                <div style="white-space: pre-line;">{{ $product['description'] }}</div>
            </div>
            <div class="col-12">
                <h4 class="mb-3">Chi tiết sản phẩm</h4>
                <table class="table table-bordered w-75">
                    <tbody>
                        <tr>
                            <th width="200">Danh mục</th>
                            <td>{{ $product['category_name'] ?? 'Đang cập nhật' }}</td>
                        </tr>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <td>{{ $product['product_name'] ?? 'Đang cập nhật' }}</td>
                        </tr>
                        <tr>
                            <th>Ngày nhập</th>
                            <td>{{ $product['import_date'] ?? 'Đang cập nhật' }}</td>
                        </tr>
                        <tr>
                            <th>Bảo hành</th>
                            <td>{{ $product['warranty'] ?? 'Đang cập nhật' }}</td>
                        </tr>
                        <tr>
                            <th>Xuất xứ</th>
                            <td>{{ $product['origin'] ?? 'Đang cập nhật' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quantityInput = document.getElementById('quantity');
            const maxQuantity = {{ $product['quantity'] }};
            const form = quantityInput.closest('form');

            form.addEventListener('submit', function (e) {
                const value = parseInt(quantityInput.value);
                if (value > maxQuantity) {
                    alert('Số lượng trong kho không đủ!');
                    e.preventDefault();
                }
            });

            quantityInput.addEventListener('input', function () {
                if (parseInt(this.value) > maxQuantity) {
                    this.value = maxQuantity;
                    alert('Số lượng trong kho không đủ!');
                }
            });
        });
    </script>
@endpush