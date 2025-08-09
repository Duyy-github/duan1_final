<?php
// Nơi này xử lý các thứ đến người dùng
namespace App\Controllers;
use App\Controllers\Controller;
use App\Models\Product;

class HomeController
{
    public function index()
    {
        $productModel = new Product();

        // Lấy top 10 sản phẩm mới nhất (theo ngày nhập)
        $topProducts = $productModel->getAll();
        $topProducts = array_slice($topProducts, 0, 10);

        // Lấy tất cả sản phẩm
        $products = $productModel->getAll();

        // Truyền sang view
        return view('User.index', [
            'topProducts' => $topProducts,
            'products' => $products
        ]);
    }
    public function showProduct($id)
    {
        $productModel = new Product();
        $product = $productModel->findById($id);

        if (!$product) {
            // Nếu không tìm thấy sản phẩm, có thể chuyển hướng hoặc báo lỗi
            return redirect('User.show')->back()->with('error', 'Không tìm thấy sản phẩm!');
        }

        return view('User.show', [
            'product' => $product
        ]);
    }
}