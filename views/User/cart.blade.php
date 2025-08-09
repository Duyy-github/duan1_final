@extends('User.layouts.user')

@section('content')
    @php
        if (!isset($_SESSION['user'])) {
            header('Location: ' . route('login'));
            exit;
        }
    @endphp
    <div class="container py-4">
        <h2 class="mb-4"><i class="bi bi-cart"></i> Giỏ Hàng</h2>
        @if(isset($_SESSION['error']))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ $_SESSION['error'] }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <form action="{{ route('user/cart/update') }}" method="POST">
            @csrf
            <div class="table-responsive bg-white rounded shadow-sm">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col"><input type="checkbox" id="selectAll"></th>
                            <th scope="col">Sản Phẩm</th>
                            <th scope="col">Đơn Giá</th>
                            <th scope="col">Số Lượng</th>
                            <th scope="col">Số Tiền</th>
                            <th scope="col">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cart as $item)
                            <tr>
                                <td><input type="checkbox" name="selected[]" value="{{ $item['product_id'] }}"></td>
                                <td class="d-flex align-items-center gap-3">
                                    <img src="{{ asset($item['image']) }}" alt="{{ $item['product_name'] }}"
                                        style="width:70px;height:70px;object-fit:cover;" class="border rounded">
                                    <div>
                                        <div class="fw-bold">{{ $item['product_name'] }}</div>
                                        <div class="text-muted small">Phân loại: {{ $item['category_name'] ?? 'Không có' }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{-- <span
                                        class="text-decoration-line-through text-muted me-2">{{ number_format($item['old_price'] ?? 0, 0, '', ',') }}
                                        đ</span> --}}
                                    <span class="fw-bold text-danger">{{ number_format($item['price'], 0, '', ',') }} đ</span>
                                </td>
                                <td>
                                    <div class="input-group input-group-sm" style="width:110px;">
                                        <button type="button" class="btn btn-outline-secondary btn-qty" data-action="minus"
                                            data-id="{{ $item['product_id'] }}">-</button>
                                        <input type="number" name="quantities[{{ $item['product_id'] }}]"
                                            value="{{ $item['quantity'] }}" min="1" class="form-control text-center"
                                            style="width:40px;">
                                        <button type="button" class="btn btn-outline-secondary btn-qty" data-action="plus"
                                            data-id="{{ $item['product_id'] }}">+</button>
                                    </div>
                                </td>
                                <td class="fw-bold text-danger">
                                    {{ number_format($item['price'] * $item['quantity'], 0, '', ',') }} đ
                                </td>
                                <td>
                                    <a href="{{ route('user/cart/remove/' . $item['product_id']) }}"
                                        class="btn btn-link text-danger p-0"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?');">
                                        Xóa
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">Giỏ hàng của bạn đang trống.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <input type="checkbox" id="selectAllBottom"> <label for="selectAllBottom" class="me-3">Chọn Tất
                        Cả</label>
                    <button type="submit" name="action" value="remove" class="btn btn-link text-danger"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa các sản phẩm đã chọn khỏi giỏ hàng?');">
                        Xóa
                    </button>
                </div>
                <div>
                    <span class="me-3">Tổng cộng (<span id="totalItems">{{ $totalItems ?? 0 }}</span> Sản phẩm):</span>
                    <span class="fs-4 fw-bold text-danger" id="totalPrice">{{ number_format($totalPrice ?? 0, 0, '', ',') }}
                        đ</span>
                    <button type="submit" name="action" value="checkout" class="btn btn-danger ms-3 px-4">Thanh
                        toán</button>
                </div>
            </div>
        </form>
        {{-- Gợi ý sản phẩm --}}
        <div class="mt-5">
            <h5 class="mb-3">Có thể bạn cũng thích</h5>
            <div class="row">
                @foreach($suggestedProducts ?? [] as $product)
                    <div class="col-md-2 mb-3">
                        <div class="card h-100">
                            <img src="{{ asset($product['image']) }}" class="card-img-top" alt="{{ $product['product_name'] }}"
                                style="height:120px;object-fit:cover;">
                            <div class="card-body p-2">
                                <div class="small">{{ $product['product_name'] }}</div>
                                <div class="fw-bold text-danger">{{ number_format($product['price'], 0, '', ',') }} đ</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Chọn tất cả
        document.getElementById('selectAll')?.addEventListener('change', function () {
            document.querySelectorAll('input[name="selected[]"]').forEach(cb => cb.checked = this.checked);
            document.getElementById('selectAllBottom').checked = this.checked;
        });
        document.getElementById('selectAllBottom')?.addEventListener('change', function () {
            document.querySelectorAll('input[name="selected[]"]').forEach(cb => cb.checked = this.checked);
            document.getElementById('selectAll').checked = this.checked;
        });

        // Tăng giảm số lượng
        document.querySelectorAll('.btn-qty').forEach(btn => {
            btn.addEventListener('click', function () {
                const input = this.parentElement.querySelector('input[type="number"]');
                let value = parseInt(input.value);
                if (this.dataset.action === 'plus') value++;
                if (this.dataset.action === 'minus' && value > 1) value--;
                input.value = value;
            });
        });

        // Kiểm tra số lượng khi nhập
        document.querySelectorAll('input[name^="quantities"]').forEach(input => {
            input.addEventListener('input', function () {
                const max = parseInt(this.dataset.max);
                if (parseInt(this.value) > max) {
                    alert('Số lượng trong kho không đủ!');
                    this.value = max;
                }
            });
        });

        // Kiểm tra khi submit form
        document.querySelector('form').addEventListener('submit', function (e) {
            let valid = true;
            document.querySelectorAll('input[name^="quantities"]').forEach(input => {
                const max = parseInt(input.dataset.max);
                if (parseInt(input.value) > max) {
                    alert('Số lượng trong kho không đủ!');
                    input.value = max;
                    valid = false;
                }
            });
            if (!valid) e.preventDefault();
        });

    </script>
@endpush