@extends('User.layouts.user')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4"><i class="bi bi-credit-card"></i> Thanh toán</h2>

        {{-- Thông báo lỗi hoặc thành công --}}
        @if(isset($_SESSION['error']))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ $_SESSION['error'] }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @php unset($_SESSION['error']); @endphp
        @endif

        @if(isset($_SESSION['success']))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ $_SESSION['success'] }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @php unset($_SESSION['success']); @endphp
        @endif

        <form action="{{ route('user/order/submit') }}" method="POST">
            @csrf
            <input type="hidden" name="action_type" id="action_type" value="order">
            <div class="row">
                {{-- Thông tin giao hàng --}}
                <div class="col-md-7">
                    <div class="card mb-4">
                        <div class="card-header fw-bold">Thông tin giao hàng</div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label">Họ Tên</label>
                                    <input type="text" name="receiver_name" class="form-control" required
                                        value="{{ $formData['receiver_name'] ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="text" name="phone_number" class="form-control" required
                                        value="{{ $formData['phone_number'] ?? '' }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Địa chỉ nhận hàng</label>
                                <input type="text" name="address" class="form-control" required
                                    value="{{ $formData['address'] ?? '' }}">
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <label class="form-label">Tỉnh/ Thành phố</label>
                                    <input type="text" name="province" class="form-control" required
                                        value="{{ $formData['province'] ?? '' }}">
                                </div>
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <label class="form-label">Quận/ Huyện</label>
                                    <input type="text" name="district" class="form-control" required
                                        value="{{ $formData['district'] ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Phường/ Xã</label>
                                    <input type="text" name="ward" class="form-control" required
                                        value="{{ $formData['ward'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Phương thức thanh toán + đơn hàng --}}
                <div class="col-md-5">
                    <div class="card mb-4">
                        <div class="card-header fw-bold">Chọn phương thức thanh toán</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod"
                                        checked>
                                    <label class="form-check-label fw-bold text-primary" for="cod">
                                        Thanh toán khi nhận hàng
                                    </label>
                                    <div class="small text-muted">Thanh toán khi nhận hàng</div>
                                </div>
                            </div>

                            {{-- Mã giảm giá --}}
                            <div class="mb-3">
                                <label class="form-label">Voucher</label>
                                <div class="input-group">
                                    <input type="text" name="voucher" class="form-control" placeholder="Nhập mã voucher"
                                        value="{{ $_SESSION['voucherCode'] ?? '' }}">
                                    <button type="submit" class="btn btn-info"
                                        onclick="document.getElementById('action_type').value='voucher'">Áp dụng</button>
                                </div>
                            </div>

                            {{-- Chi tiết đơn hàng --}}
                            <div class="mb-3">
                                <div class="fw-bold mb-2">CHI TIẾT ĐƠN HÀNG</div>
                                <div class="d-flex justify-content-between">
                                    <span>Tạm tính ({{ $totalItems ?? 0 }} sản phẩm)</span>
                                    <span>{{ number_format($totalPrice ?? 0, 0, '', ',') }} đ</span>
                                </div>

                                @if(!empty($_SESSION['discount']))
                                    <div class="d-flex justify-content-between text-success">
                                        <span>Giảm giá ({{ $_SESSION['discount'] }}%)</span>
                                        <span>-{{ number_format(($totalPrice * $_SESSION['discount']) / 100, 0, '', ',') }} đ</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between fs-5 fw-bold text-danger">
                                        <span>Tổng cộng:</span>
                                        <span>{{ number_format($totalPrice - ($totalPrice * $_SESSION['discount'] / 100), 0, '', ',') }} đ</span>
                                    </div>
                                @else
                                    <hr>
                                    <div class="d-flex justify-content-between fs-5 fw-bold text-danger">
                                        <span>Tổng cộng:</span>
                                        <span>{{ number_format($totalPrice ?? 0, 0, '', ',') }} đ</span>
                                    </div>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-danger w-100 py-2 fs-5"
                                onclick="document.getElementById('action_type').value='order'">Đặt hàng</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Danh sách sản phẩm trong đơn hàng --}}
            <div class="card mt-4">
                <div class="card-header fw-bold">Sản phẩm trong đơn hàng</div>
                <div class="card-body">
                    @foreach($cart as $item)
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ file_url($item['image']) }}" alt="{{ $item['product_name'] }}"
                                style="width:60px;height:60px;object-fit:cover;" class="border rounded me-3">
                            <div class="flex-grow-1">
                                <div class="fw-bold">{{ $item['product_name'] }}</div>
                                <div class="text-muted small">Phân loại: {{ $item['category_name'] ?? 'Không có' }}</div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-danger">{{ number_format($item['price'], 0, '', ',') }} đ</div>
                                <div class="small">Số lượng: {{ $item['quantity'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </form>
    </div>
@endsection
