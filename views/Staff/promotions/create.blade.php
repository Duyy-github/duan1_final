@extends('staff.layouts.admin')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4"><i class="bi bi-plus-circle"></i> Thêm mã giảm giá mới</h2>
        @if(isset($_SESSION['error']))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ $_SESSION['error'] }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @php unset($_SESSION['error']); @endphp
        @endif

        <div class="card mb-4">
            <div class="card-header fw-bold">Thêm mã giảm giá</div>
            <div class="card-body">
                <form action="{{ route('staff/promotions/store') }}" method="POST" id="promotionForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tên mã</label>
                            <input type="text" name="name" class="form-control" id="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phần trăm giảm (%)</label>
                            <input type="number" name="discount_percentage" class="form-control" min="0" max="100" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Ngày bắt đầu</label>
                            <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}" id="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ngày kết thúc</label>
                            <input type="date" name="end_date" class="form-control"
                                value="{{ date('Y-m-d', strtotime('+1 month')) }}" id="end_date" required>
                        </div>
                    </div>

                    <!-- Dropdown chọn kiểu mã giảm giá -->
                    <div class="mb-3">
                        <label class="form-label">Áp dụng cho</label>
                        <select name="apply_type" id="apply_type" class="form-control" required>
                            <option value="order">Đơn hàng</option>
                            <option value="product">Sản phẩm</option>
                        </select>
                    </div>

                    <!-- Field hiển thị khi chọn 'Sản phẩm' -->
                    <div class="mb-3" id="product_section" style="display: none;">
                        <label class="form-label">Chọn sản phẩm áp dụng mã giảm giá</label>
                        <select name="product_id" class="form-control">
                            @if($products && count($products) > 0)
                                @foreach ($products as $product)
                                    <option value="{{ $product['product_id'] }}">{{ $product['product_name'] }}</option>
                                @endforeach
                            @else
                                <option value="">Không có sản phẩm</option>
                            @endif
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                    <a href="{{ route('staff/promotions') }}" class="btn btn-secondary">Quay lại</a>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript để xử lý sự kiện thay đổi lựa chọn 'Áp dụng cho' và validation -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const applyTypeSelect = document.getElementById('apply_type');
            const productSection = document.getElementById('product_section');

            // Lắng nghe sự kiện thay đổi giá trị chọn lựa
            applyTypeSelect.addEventListener('change', function () {
                if (applyTypeSelect.value === 'product') {
                    productSection.style.display = 'block';  // Hiển thị phần chọn sản phẩm
                } else {
                    productSection.style.display = 'none';   // Ẩn phần chọn sản phẩm
                }
            });

            // Validate form trước khi gửi
            const form = document.getElementById('promotionForm');
            form.addEventListener('submit', function (event) {
                let valid = true;
                const name = document.getElementById('name').value;
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;

                // Kiểm tra tên mã giảm giá: Không có khoảng trắng, không có dấu
                if (/[^a-zA-Z0-9]/.test(name)) {
                    alert('Tên mã giảm giá không được chứa ký tự đặc biệt hoặc dấu cách!');
                    valid = false;
                }

                // Kiểm tra ngày bắt đầu và ngày kết thúc không được quá khứ
                const today = new Date().toISOString().split('T')[0]; // Lấy ngày hôm nay theo định dạng yyyy-mm-dd
                if (startDate < today) {
                    alert('Ngày bắt đầu không được chọn quá khứ!');
                    valid = false;
                }

                if (endDate < today) {
                    alert('Ngày kết thúc không được chọn quá khứ!');
                    valid = false;
                }

                // Nếu không hợp lệ, ngừng gửi form
                if (!valid) {
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
