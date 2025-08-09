@extends('User.layouts.user')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="bi bi-list-check"></i> Đơn hàng của bạn</h2>

    @if(empty($orders) || count($orders) === 0)
        <div class="text-center text-muted py-5">
            <i class="bi bi-box-seam" style="font-size: 2rem;"></i><br>
            Bạn chưa có đơn hàng nào.
        </div>
    @else
        <div class="table-responsive bg-white rounded shadow-sm">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Mã ĐH</th>
                        <th>Ngày đặt</th>
                        <th>Người nhận</th>
                        <th>Địa chỉ</th>
                        <th>SĐT</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order['order_id'] }}</td>
                            <td>{{ date('d/m/Y H:i', strtotime($order['order_date'])) }}</td>
                            <td>{{ $order['receiver_name'] }}</td>
                            <td>{{ $order['address'] }}</td>
                            <td>{{ $order['phone_number'] }}</td>
                            <td class="fw-bold text-danger">{{ number_format($order['total_amount'], 0, '', ',') }} đ</td>
                            <td>
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
                                        'delivering' => 'success',
                                        'cancelled' => 'danger',
                                        'delivered' => 'success',
                                        'returned' => 'secondary',
                                        'completed' => 'success',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">{{ $statusMap[$order['status']] ?? ucfirst($order['status']) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('user/orders/show/' . $order['order_id']) }}" class="btn btn-sm btn-outline-primary">
                                    Xem
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection