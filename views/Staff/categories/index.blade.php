@extends('Staff.layouts.admin')

@section('content')
    <h1>Danh sách danh mục</h1>

     @php
    if(!empty($_SESSION['flash']))
    {
        foreach ($_SESSION['flash'] as $type => $msg) {
            echo "<div class='alert alert-$type'>$msg</div>";
        }
        unset($_SESSION['flash']);
    }
    @endphp

    <div class="mb-3 text-end">
        <a href="{{ route('staff/categories/create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Thêm danh mục
        </a>
    </div>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>STT</th>
                <th>Tên danh mục</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $index => $category)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $category['category_name'] }}</td>
                    <td>
                        <form action="{{ route('staff/categories/'  . 'destroy/'. $category['category_id']) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                            @csrf
                            <button class="btn btn-sm btn-danger" type="submit">
                                <i class="bi bi-trash"></i> Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection