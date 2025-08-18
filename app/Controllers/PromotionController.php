<?php
namespace App\Controllers;

use App\Models\Promotion;
use App\Models\Product;
use App\Models\Category;
use App\Controllers\Controller;


class PromotionController
{
    protected $promotion;
    protected $productModel;

    public function __construct()
    {
        $this->promotion = new Promotion();
        $this->productModel = new Product();
    }

    public function index()
    {
        $promotions = $this->promotion->getAll();
        return view('staff.promotions.index', ['promotions' => $promotions]);
    }

    public function create()
    {
        $products = $this->productModel->getAll();
        return view('staff.promotions.create', ['products' => $products]);
    }

    public function store()
    {
        // Nhận dữ liệu từ form
        $data = [
            'name' => $_POST['name'] ?? '',
            'discount_percentage' => $_POST['discount_percentage'] ?? '',
            'start_date' => $_POST['start_date'] ?? '',
            'end_date' => $_POST['end_date'] ?? '',
            'apply_type' => $_POST['apply_type'] ?? 'order',  // Lưu kiểu áp dụng (order hoặc product)
            // 'product_id' => $_POST['product_id'] ?? null  // Nếu apply_type là 'product', lưu product_id
            'product_id' => null
        ];
        if ($data['apply_type'] === 'product') {
            $data['product_id'] = $_POST['product_id'] ?? null;  // Lấy product_id khi chọn sản phẩm
        }

        // Kiểm tra các trường bắt buộc
        $requiredFields = ['name', 'discount_percentage', 'start_date', 'end_date', 'apply_type'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $_SESSION['error'] = 'Tất cả các trường đều bắt buộc!';
                header('Location: ' . route('staff/promotions/create'));
                exit;
            }
        }

        // Nếu áp dụng cho sản phẩm, cần kiểm tra product_id
        if ($data['apply_type'] === 'product' && !$data['product_id']) {
            $_SESSION['error'] = 'Cần chọn sản phẩm khi áp dụng cho sản phẩm!';
            header('Location: ' . route('staff/promotions/create'));
            exit;
        }

        // Thêm mã giảm giá vào cơ sở dữ liệu
        $result = $this->promotion->create($data);
        if ($result) {
            $_SESSION['success'] = 'Thêm mã giảm giá thành công!';
        } else {
            $_SESSION['error'] = 'Thêm mã giảm giá thất bại!';
        }

        // Điều hướng về trang danh sách mã giảm giá
        header('Location: ' . route('staff/promotions'));
        exit;
    }

    public function destroy($id)
    {
        $result = $this->promotion->delete($id);
        if ($result) {
            $_SESSION['success'] = 'Xóa mã giảm giá thành công!';
        } else {
            $_SESSION['error'] = 'Xóa mã giảm giá thất bại!';
        }
        header('Location: ' . route('staff/promotions'));
        exit;
    }

    public function show($id)
    {
        $promotion = $this->promotion->getByCode($id); // Sử dụng getByCode tạm thời, cần điều chỉnh nếu dùng promotion_id
        if (!$promotion) {
            $_SESSION['error'] = 'Không tìm thấy mã giảm giá!';
            header('Location: ' . route('staff.promotions.index'));
            exit;
        }
        return view('staff.promotions.show', ['promotion' => $promotion]);
    }
}
