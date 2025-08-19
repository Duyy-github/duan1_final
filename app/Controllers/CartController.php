<?php
namespace App\Controllers;
use App\Models\Product;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = $_SESSION['cart'] ?? [];
        $totalItems = 0;
        $totalPrice = 0;

        foreach ($cart as $item) {
            $totalItems += $item['quantity'];
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Gợi ý sản phẩm (tuỳ chọn)
        $suggestedProducts = (new Product())->getAll();

        return view('User.cart', [
            'cart' => $cart,
            'totalItems' => $totalItems,
            'totalPrice' => $totalPrice,
            'suggestedProducts' => $suggestedProducts
        ]);
    }

    // Thêm sản phẩm vào giỏ hàng

    public function add($id)
    {

        if (!isset($_SESSION['user'])) {
            echo "<script>
            alert('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!');
            window.location.href = '" . route('login') . "';
        </script>";
            exit;
        }

        $product = (new Product())->findById($id);
        if (!$product) {
            header('Location: /duan1_final/user');
            exit;
        }

        $quantity = isset($_POST['quantity']) ? max(1, intval($_POST['quantity'])) : 1;

        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = [
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'image' => $product['image'],
                'price' => $product['price'],
                'quantity' => 0,
                'category_name' => $product['category_name'] ?? null,
            ];
        }

        // Kiểm tra số lượng cộng dồn không vượt quá tồn kho
        $currentQty = $_SESSION['cart'][$id]['quantity'];
        $newQty = $currentQty + $quantity;

        if ($newQty > $product['quantity']) {
            $_SESSION['error'] = "Sản phẩm '{$product['product_name']}' chỉ còn {$product['quantity']} sản phẩm trong kho!";
            // Giữ nguyên số lượng hiện tại trong giỏ, không cộng thêm
            header('Location: ' . route('user/products/show/' . $id));
            exit;
        }

        // Nếu đủ hàng thì mới cộng
        $_SESSION['cart'][$id]['quantity'] = $newQty;
        // $_SESSION['cart'][$id]['quantity'] += $quantity;

        // Thêm thông báo vào session
        $_SESSION['success'] = 'Đã thêm sản phẩm vào giỏ hàng!';
        header('Location: /duan1_final/user');
        exit;
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: /duan1_final/user/cart');
        exit;
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function update()
    {
        // Xử lý khi bấm "Thanh toán"
        if (isset($_POST['action']) && $_POST['action'] === 'checkout') {
            // Kiểm tra giỏ hàng có sản phẩm không
            if (empty($_SESSION['cart'])) {
                $_SESSION['error'] = 'Giỏ hàng của bạn hiện tại không có sản phẩm. Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán.';
                header('Location: ' . route('user/cart'));
                exit;
            }
            // Nếu giỏ hàng có sản phẩm, điều hướng đến trang thanh toán
            header('Location: ' . route('user/payment'));
            exit;
        }
        // Xóa nhiều sản phẩm được chọn
        if (isset($_POST['action']) && $_POST['action'] === 'remove' && !empty($_POST['selected'])) {
            foreach ($_POST['selected'] as $id) {
                if (isset($_SESSION['cart'][$id])) {
                    unset($_SESSION['cart'][$id]);
                }
            }
            header('Location: /duan1_final/user/cart');
            exit;
        }

        // Cập nhật số lượng
        if (isset($_POST['quantities']) && is_array($_POST['quantities'])) {
            $errors = [];
            foreach ($_POST['quantities'] as $id => $qty) {
                $product = (new Product())->findById($id);
                $maxQty = $product ? $product['quantity'] : 0;
                if (isset($_SESSION['cart'][$id])) {
                    if ($qty > $maxQty) {
                        $_SESSION['cart'][$id]['quantity'] = $maxQty;
                        $errors[] = $_SESSION['cart'][$id]['product_name'];
                    } else {
                        $_SESSION['cart'][$id]['quantity'] = max(1, intval($qty));
                    }
                }
            }
            if (!empty($errors)) {
                $_SESSION['error'] = 'Số lượng trong kho không đủ cho các sản phẩm: ' . implode(', ', $errors);
            }
        }
        header('Location: /duan1_final/user/cart');
        exit;
    }
}