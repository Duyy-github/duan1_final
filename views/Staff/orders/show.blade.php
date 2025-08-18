@extends('Staff.layouts.admin')

@section('content')
    <h1>Chi tiết đơn hàng #{{ $order['order_id'] ?? 'N/A' }}</h1>

    {{-- Hiển thị thông báo lỗi hoặc thành công --}}
    @php
        if (!empty($_SESSION['flash'])) {
            foreach ($_SESSION['flash'] as $type => $msg) {
                echo "<div class='alert alert-$type'>$msg</div>";
            }
            unset($_SESSION['flash']);
        }
    @endphp

    @if ($order)
        {{-- Thông tin đơn hàng --}}
        <div class="card mb-4">
            <div class="card-header fw-bold">Thông tin đơn hàng</div>
            <div class="card-body">
                <p><strong>Ngày đặt:</strong> {{ $order['order_date'] ?? 'N/A' }}</p>
                <p><strong>Tổng tiền:</strong> {{ number_format($order['total_amount'] ?? 0, 0, '', ',') }} đ</p>
                <p><strong>Trạng thái hiện tại:</strong>
                    @php
                        $statusLabels = [
                            'pending' => 'Chờ xử lý',
                            'processing' => 'Đang xử lý',
                            'delivering' => 'Đang giao',
                            'delivered' => 'Đã giao',
                            // 'completed' => 'Đã hoàn thành',
                            // 'cancelled' => 'Đã hủy',
                            // 'returned' => 'Hoàn hàng',
                        ];
                        echo $statusLabels[$order['status']] ?? $order['status'];
                    @endphp
                </p>
                <p><strong>Số điện thoại:</strong> {{ $order['phone_number'] ?? 'N/A' }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order['address'] ?? 'N/A' }}</p>
                <p><strong>Người nhận:</strong> {{ $order['receiver_name'] ?? 'N/A' }}</p>
            </div>
        </div>

        {{-- Chi tiết sản phẩm --}}
        <div class="card mb-4">
            <div class="card-header fw-bold">Chi tiết sản phẩm</div>
            <div class="card-body">
                @if ($orderDetails && count($orderDetails) > 0)
                    @foreach ($orderDetails as $detail)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-grow-1">
                                <div class="fw-bold">{{ $detail['product_name'] ?? 'Không có tên' }}</div>
                                <div class="text-muted small">Số lượng: {{ $detail['quantity'] ?? 0 }}</div>
                                <div class="text-muted small">Đơn giá: {{ number_format($detail['unit_price'] ?? 0, 0, '', ',') }} đ</div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-danger">
                                    {{ number_format(($detail['unit_price'] ?? 0) * ($detail['quantity'] ?? 0), 0, '', ',') }} đ
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>Không có sản phẩm trong đơn hàng.</p>
                @endif
            </div>
        </div>

        {{-- Form thay đổi trạng thái --}}
        @php
            // Danh sách trạng thái theo thứ tự xử lý
            $statusOptions = [
                'pending' => 'Chờ xử lý',
                'processing' => 'Đang xử lý',
                'delivering' => 'Đang giao',
                'delivered' => 'Đã giao',
                // 'completed' => 'Đã hoàn thành',
                'cancelled' => 'Đã hủy',
                // 'returned' => 'Hoàn hàng',
            ];

            $statusKeys = array_keys($statusOptions);
            $currentStatus = $order['status'];
            $currentIndex = array_search($currentStatus, $statusKeys);
        @endphp

        <form action="{{ route('staff/orders/updateStatus') }}" method="POST" class="mb-4">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order['order_id'] ?? '' }}">
            <div class="mb-3">
                <label for="status" class="form-label">Chọn trạng thái mới</label>

                <select name="status" id="status" class="form-select" required
                    {{ $currentIndex >= count($statusKeys) - 1 ? 'disabled' : '' }}>
                    @for ($i = $currentIndex + 1; $i < count($statusKeys); $i++)
                        <option value="{{ $statusKeys[$i] }}">{{ $statusOptions[$statusKeys[$i]] }}</option>
                    @endfor
                </select>
            </div>

            @if ($currentIndex < count($statusKeys) - 1)
                <button type="submit" class="btn btn-primary">Thay đổi trạng thái</button>
            @else
                <div class="alert alert-info">Đơn hàng đã ở trạng thái cuối cùng, không thể thay đổi thêm.</div>
            @endif
        </form>

        <a href="{{ route('staff/orders') }}" class="btn btn-secondary">Quay lại</a>
    @else
        <div class="alert alert-warning">Không tìm thấy đơn hàng.</div>
    @endif
@endsection
