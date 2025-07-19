<?php
namespace App\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Controllers\Controller;

class ProductController extends Controller
{
    private $productModel;
    private $categoryModel;
    public function __construct()
    {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }
    public function index()
    {
        $products = $this->productModel->getAll();
        return view('Staff.products.index', compact('products'));
    }
    public function show($id)
    {
        $product = $this->productModel->findById($id);
        return view('Staff.products.show', compact('product'));
    }
    //thêm sản phẩm
    public function create()
    {
        $categories = $this->categoryModel->getAll();
        return view('Staff.products.create', compact('categories'));
    }
    public function store()
    {
        // Lấy dữ liệu từ form
        $data = [
            'product_name' => $_POST['product_name'],
            'price' => $_POST['price'],
            'quantity' => $_POST['quantity'],
            'category_id' => $_POST['category_id'],
            'description' => $_POST['description'] ?? null,
            'import_date' => $_POST['import_date'],
        ];

        // Xử lý upload ảnh
        if (is_upload('image')) {
            $data['image'] = $this->uploadFile($_FILES['image'], 'products');
        } else {
            $data['image'] = null;
        }

        // Xử lý thêm
        try {
            $this->productModel->insert($data);
            setFlash('success', 'Thêm thành công');
        } catch (\Exception $e) {
            setFlash('error', 'Lỗi khi thêm sản phẩm: ' . $e->getMessage());
        }
        redirect('staff/products');
    }

    public function edit($id)
    {
        $categories = $this->categoryModel->getAll();
        $product = $this->productModel->findById($id);

        if (!$product) {
            setFlash('error', 'Không tìm thấy sản phẩm');
            redirect('staff/products');
        }
        return view('Staff.products.edit', compact('categories', 'product'));
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->productModel->delete($id);
            if ($deleted > 0) {
                setFlash('success', 'Xoá sản phẩm thành công');
            } else {
                setFlash('error', 'Xoá sản phẩm k thành công');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            setFlash('error', 'Xoá sản phẩm k thành công ' . $e->getMessage());
        }
        redirect('staff/products');
    }

    public function update($id)
    {
        // Lấy dữ liệu từ form
        $data = [
            'product_name' => $_POST['product_name'],
            'price' => $_POST['price'],
            'category_id' => $_POST['category_id'],
            'import_date' => $_POST['import_date'],
            'quantity' => $_POST['quantity'],
            'description' => $_POST['description'],
        ];

        // Xử lý hình ảnh riêng
        $product = $this->productModel->findById($id);
        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            // Xóa ảnh cũ
            if (!empty($product['image']) && file_exists('storage/products/' . $product['image'])) {
                unlink('storage/products/' . $product['image']);
            }
            $data['image'] = $this->uploadFile($_FILES['image'], 'products');
        } else {
            // Lưu lại ảnh cũ nếu không sửa ảnh
            $data['image'] = $product['image'];
        }

        // Xử lý sửa
        try {
            $this->productModel->update($id, $data);
            setFlash('success', 'Sửa thành công');
        } catch (\Exception $e) {
            setFlash('error', 'Lỗi khi sửa sản phẩm: ' . $e->getMessage());
        }
        redirect('staff/products');
    }
}