@extends('Staff.layouts.admin')

@section('content')
    <h1>Danh sách người dùng</h1>

    {{-- Hiển thị lỗi hoặc thông báo thành công --}}
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
                <th>Tên</th>
                <th>Email</th>
                <th>Quyền</th>
                <th>Ảnh</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user['username'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['role_name'] ?? 'Không xác định' }}</td>
                    <td>
                        @if ($user['image'])
                            {{-- <img src="{{ asset('uploads/users/' . $user['image']) }}" alt="{{ $user['username'] }}" class="img-thumbnail" style="max-width: 80px;"> --}}
                        @else
                            <small>Không có ảnh</small>
                        @endif
                    </td>
                    <td>{{ $user['status'] === 'active' ? 'Hoạt động' : 'Bị khóa' }}</td>
                    <td>
                        <form action="{{ route('staff/users/update-status/' . $user['user_id']) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn thay đổi trạng thái?')">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm btn-{{ $user['status'] === 'active' ? 'danger' : 'success' }}" type="submit">
                                {{ $user['status'] === 'active' ? 'Vô hiệu hóa' : 'Kích hoạt' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection