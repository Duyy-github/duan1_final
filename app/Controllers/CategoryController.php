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

    // public function show($id)
    // {
    //     $category = $this->categoryModel->findById($id);
    //     return view('Staff.categories.show', compact('category'));
    // }
}