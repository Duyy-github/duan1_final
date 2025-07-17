<?php
namespace App\Controllers;
use App\Models\Product;
use App\Controllers\Controller;

class ProductController extends Controller
{
    private $productModel;
    public function __construct()
    {
        $this->productModel = new Product();
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
}