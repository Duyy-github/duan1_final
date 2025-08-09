<!-- filepath: d:\laragon\www\duan1_final\views\Staff\index.blade.php -->
@extends('Staff.layouts.admin')

@section('content')
    <h1>Danh sách đơn hàng</h1>

    {{-- Hiển thị thông báo lỗi hoặc thành công --}}
    @php
        if (!empty($_SESSION['flash'])) {
            foreach ($_SESSION['flash'] as $type => $msg) {
                echo "<div class='alert alert-$type'>$msg</div>";
            }
            unset($_SESSION['flash']);
        }
    @endphp

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>STT</th>
                <th>ID Đơn hàng</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order['order_id'] }}</td>
                    <td>{{ $order['order_date'] }}</td>
                    <td>{{ number_format($order['total_amount'], 0, '', ',') }} đ</td>
                    <td>
                        @php
                            $statusMap = [
                                'pending' => ['label' => 'Chờ xử lý', 'class' => 'secondary'],
                                'processing' => ['label' => 'Đang xử lý', 'class' => 'warning'],
                                'delivering' => ['label' => 'Đang giao', 'class' => 'info'],
                                'delivered' => ['label' => 'Đã giao', 'class' => 'primary'],
                                'completed' => ['label' => 'Đã hoàn thành', 'class' => 'success'],
                                'cancelled' => ['label' => 'Đã hủy', 'class' => 'danger'],
                                'returned' => ['label' => 'Đã trả hàng', 'class' => 'dark'],
                            ];
                            $status = $order['status'];
                            $statusLabel = $statusMap[$status]['label'] ?? $status;
                            $statusClass = $statusMap[$status]['class'] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $statusClass }}">{{ $statusLabel }}</span>
                    </td>
                    <td>
                        <a href="{{ route('staff/orders/show/' . $order['order_id']) }}" class="btn btn-sm btn-info me-1">
                            <i class="bi bi-eye"></i> Xem chi tiết
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection