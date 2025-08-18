@extends('User.layouts.user')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="bi bi-list-check"></i> Chi tiết đơn hàng</h2>

    @if(empty($order))
        <div class="text-center text-muted py-5">
            <i class="bi bi-box-seam" style="font-size: 2rem;"></i><br>
            Không tìm thấy đơn hàng.
        </div>
    @else
        <div class="card mb-4">
            <div class="card-body">
                <h5>Đơn hàng #{{ $order['order_id'] }}</h5>
                <p><strong>Ngày đặt:</strong> {{ date('d/m/Y H:i', strtotime($order['order_date'])) }}</p>
                <p><strong>Người nhận:</strong> {{ $order['receiver_name'] }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order['address'] }}</p>
                <p><strong>SĐT:</strong> {{ $order['phone_number'] }}</p>
                <p><strong>Tổng tiền:</strong> <span class="fw-bold text-danger">{{ number_format($order['total_amount'], 0, '', ',') }} đ</span></p>
                <p><strong>Trạng thái:</strong>
                    @php
                        $statusMap = [
                            'pending' => 'Đang chờ xử lý',
                            'processing' => 'Đang xử lý',
                            'delivering' => 'Đang giao',
                            'cancelled' => 'Đã hủy',
                            'delivered' => 'Đã giao',
                            'returned' => 'Đã trả hàng',
                            'completed' => 'Đã hoàn thành'
                        ];
                        $statusClass = match($order['status']) {
                            'pending' => 'warning',
                            'processing' => 'info',
                            'delivering' => 'primary',
                            'cancelled' => 'danger',
                            'delivered' => 'success',
                            'returned' => 'secondary',
                            'completed' => 'success',
                            default => 'secondary'
                        };
                    @endphp
                    <span class="badge bg-{{ $statusClass }}">{{ $statusMap[$order['status']] ?? ucfirst($order['status']) }}</span>
                </p>

                @if(in_array($order['status'], ['pending', 'processing']))
                    <form action="{{ route('user/orders/cancel/' . $order['order_id']) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-danger mt-2">
                            <i class="bi bi-x-circle"></i> Hủy đơn hàng
                        </button>
                    </form>
                @endif

                @if($order['status'] === 'delivering')
                    <form action="{{ route('user/orders/receive/' . $order['order_id']) }}" method="POST" onsubmit="return confirm('Bạn đã nhận được hàng?');">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success mt-2">
                            <i class="bi bi-box-arrow-in-down"></i> Tôi đã nhận được hàng
                        </button>
                    </form>
                @endif

                <!-- Nút hoàn thành đơn hàng -->
                @if($order['status'] === 'delivered')
                    <form action="{{ route('user/orders/complete/' . $order['order_id']) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn hoàn thành đơn hàng này?');">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success mt-2">
                            <i class="bi bi-check-circle"></i> Hoàn thành đơn hàng
                        </button>
                    </form>
                @endif

                {{-- trả hàng? --}}
                @if($order['status'] === 'delivered')
                    <form action="{{ route('user/orders/return/' . $order['order_id']) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn yêu cầu trả hàng?');">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning mt-2">
                            <i class="bi bi-arrow-return-left"></i> Yêu cầu trả hàng
                        </button>
                    </form>
                @endif

                {{-- @if($order['status'] === 'cancelled')
                    <form action="{{ route('user/orders/delete/' . $order['order_id']) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa đơn hàng này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger mt-2">
                            <i class="bi bi-trash-fill"></i> Xóa đơn hàng
                        </button>
                    </form>
                @endif --}}
            </div>
        </div>

        @if(empty($details) || count($details) === 0)
            <div class="text-center text-muted py-5">
                <i class="bi bi-box-seam" style="font-size: 2rem;"></i><br>
                Không có sản phẩm trong đơn hàng.
            </div>
        @else
            <div class="table-responsive bg-white rounded shadow-sm">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($details as $detail)
                            <tr>
                                <td>{{ $detail['product_name'] }}</td>
                                <td>{{ $detail['quantity'] }}</td>
                                <td>{{ number_format($detail['price'], 0, '', ',') }} đ</td>
                                <td>{{ number_format($detail['quantity'] * $detail['price'], 0, '', ',') }} đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif
</div>
@endsection