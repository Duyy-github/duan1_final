@extends('staff.layouts.admin')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4"><i class="bi bi-tags"></i> Quản lý mã giảm giá</h2>
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

        <!-- Nút Thêm mã giảm giá -->
        <div class="mb-4">
            <a href="{{ route('staff/promotions/create') }}" class="btn btn-primary">Thêm mã giảm giá</a>
        </div>

        <!-- Danh sách mã giảm giá -->
        <div class="card">
            <div class="card-header fw-bold">Danh sách mã giảm giá</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tên mã</th>
                            <th>Phần trăm giảm</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Áp dụng cho</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($promotions as $promo)
                            <tr>
                                <td>{{ $promo['name'] }}</td>
                                <td>{{ $promo['discount_percentage'] }}%</td>
                                <td>{{ $promo['start_date'] }}</td>
                                <td>{{ $promo['end_date'] }}</td>
                                <td>{{ $promo['product_id'] ?? 'Tất cả' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('staff/promotions/show/'. $promo['promotion_id']) }}" class="btn btn-info btn-sm">Xem</a>
                                        <form action="{{ route('staff/promotions/destroy/'. $promo['promotion_id']) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection