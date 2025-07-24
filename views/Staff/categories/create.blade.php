@extends('Staff.layouts.admin')

@section('content')
    <div class="container" style="max-width: 600px;">
        <h2 class="mb-4">Thêm danh mục mới</h2>
        {{-- Hiển thị lỗi --}}
        @if (isset($_SESSION['flash']['error']))
            <div class='alert alert-danger'>
                {{$_SESSION['flash']['error']}}
            </div>
            <?php unset($_SESSION['flash']) ?>
        @endif
        <form action="{{ route('staff/categories/store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="category_name" class="form-label">Tên danh mục</label>
                <input type="text" class="form-control" id="category_name" name="category_name" required>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Thêm danh mục</button>
            <a href="{{ route('staff/categories') }}" class="btn btn-secondary ms-2">Quay lại</a>
        </form>
    </div>
@endsection