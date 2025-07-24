<?php
namespace App\Controllers;
use App\Models\Category;
use App\Controllers\Controller;

class CategoryController extends Controller
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    public function index()
    {
        $categories = $this->categoryModel->getAll();
        return view('Staff.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('Staff.categories.create');
    }
    public function store()
    {
        // Lấy dữ liệu từ form
        $data = [
            'category_name' => $_POST['category_name'],
        ];

        // Xử lý thêm
        try {
            $this->categoryModel->insert($data);
            setFlash('success', 'Thêm danh mục thành công');
        } catch (\Exception $e) {
            setFlash('error', 'Lỗi khi thêm danh mục hoặc danh mục đã tồn tại: ' . $e->getMessage());
        }
        redirect('staff/categories');
    }
    public function destroy($id)
    {
        try {
            $deleted = $this->categoryModel->delete($id);
            if ($deleted > 0) {
                setFlash('success', 'Xoá danh mục thành công');
            } else {
                setFlash('error', 'Xoá danh mục k thành công');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            setFlash('error', 'Xoá danh mục k thành công ' . $e->getMessage());
        }
        redirect('staff/categories');
    }
}