@extends('User.layouts.user')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-primary fw-bold d-flex align-items-center gap-2">
        <i class="bi bi-bag-check-fill"></i> Đơn hàng của bạn
    </h2>

    @if(empty($orders) || count($orders) === 0)
        <div class="text-center text-muted py-5">
            <i class="bi bi-box-seam" style="font-size: 4rem;"></i>
            <p class="mt-3 fs-5">Bạn chưa có đơn hàng nào.</p>
            <a href="{{ route('user') }}" class="btn btn-outline-primary mt-3">
                Tiếp tục mua sắm
            </a>
        </div>
    @else
        <div class="table-responsive shadow rounded bg-white">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-primary text-primary">
                    <tr>
                        <th>Mã ĐH</th>
                        <th>Ngày đặt</th>
                        <th>Người nhận</th>
                        <th>Địa chỉ</th>
                        <th>SĐT</th>
                        <th class="text-end">Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
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
                        <tr class="align-middle" style="transition: background-color 0.3s;">
                            <td class="fw-semibold text-primary">#{{ $order['order_id'] }}</td>
                            <td>{{ date('d/m/Y H:i', strtotime($order['order_date'])) }}</td>
                            <td>{{ $order['receiver_name'] }}</td>
                            <td style="max-width: 180px; word-wrap: break-word;">{{ $order['address'] }}</td>
                            <td>{{ $order['phone_number'] }}</td>
                            <td class="fw-bold text-end text-danger" style="min-width: 120px;">{{ number_format($order['total_amount'], 0, '', ',') }} đ</td>
                            <td>
                                <span 
                                    class="badge bg-{{ $statusClass }}" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    title="{{ $statusMap[$order['status']] ?? ucfirst($order['status']) }}"
                                    style="cursor: help;"
                                >
                                    {{ $statusMap[$order['status']] ?? ucfirst($order['status']) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('user/orders/show/' . $order['order_id']) }}" class="btn btn-sm btn-outline-primary" title="Xem chi tiết đơn hàng">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@push('scripts')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection