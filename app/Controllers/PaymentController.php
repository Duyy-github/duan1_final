<?php
namespace App\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;

class PaymentController
{
    // Hiển thị trang thanh toán
    public function index()
    {
        $cart = $_SESSION['cart'] ?? [];
        $totalItems = array_sum(array_column($cart, 'quantity'));
        $totalPrice = 0;

        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Lấy dữ liệu form đã lưu (nếu có)
        $formData = $_SESSION['formData'] ?? [];
        unset($_SESSION['formData']);

        return view('User.payment', [
            'cart' => $cart,
            'totalItems' => $totalItems,
            'totalPrice' => $totalPrice,
            'discount' => $_SESSION['discount'] ?? 0,
            'voucherCode' => $_SESSION['voucherCode'] ?? null,
            'formData' => $formData,
        ]);
    }


    // Xử lý đặt hàng
    public function submit()
    {
        $actionType = $_POST['action_type'] ?? 'order';

        if ($actionType === 'voucher') {
            // Lưu dữ liệu form trước khi xử lý voucher
            $_SESSION['formData'] = [
                'receiver_name' => $_POST['receiver_name'] ?? '',
                'phone_number' => $_POST['phone_number'] ?? '',
                'address' => $_POST['address'] ?? '',
                'province' => $_POST['province'] ?? '',
                'district' => $_POST['district'] ?? '',
                'ward' => $_POST['ward'] ?? '',
            ];

            $code = trim($_POST['voucher'] ?? '');

            if (empty($code)) {
                $_SESSION['error'] = 'Vui lòng nhập mã giảm giá!';
                header('Location: /duan1_final/user/payment');
                exit;
            }

            $promotionModel = new \App\Models\Promotion();
            $promotion = $promotionModel->getByCode($code);

            if (!$promotion) {
                $_SESSION['error'] = 'Mã giảm giá không hợp lệ hoặc đã hết hạn!';
            } else {
                if ($promotion['apply_type'] === 'order') {
                    $_SESSION['discount'] = $promotion['discount_percentage'];
                    $_SESSION['voucherCode'] = $code;
                    $_SESSION['success'] = 'Áp dụng mã giảm giá thành công!';
                } else {
                    $_SESSION['error'] = 'Mã giảm giá này không áp dụng cho toàn bộ đơn hàng!';
                }
            }

            header('Location: /duan1_final/user/payment');
            exit;
        }

        // Nếu không phải apply voucher thì xử lý đặt hàng

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            $_SESSION['error'] = 'Giỏ hàng trống!';
            header('Location: /duan1_final/user/payment');
            exit;
        }

        // Tính tổng tiền
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Áp dụng giảm giá nếu có
        $discount = $_SESSION['discount'] ?? 0;
        if ($discount > 0) {
            $totalAmount -= ($totalAmount * $discount / 100);
        }

        // Kiểm tra thông tin giao hàng
        if (empty($_POST['phone_number']) || empty($_POST['address']) || empty($_POST['receiver_name'])) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin giao hàng!';
            header('Location: /duan1_final/user/payment');
            exit;
        }

        // Lưu đơn hàng
        $order = new Order();
        $orderId = $order->create([
            'user_id' => $_SESSION['user']['id'] ?? null,
            'order_date' => date('Y-m-d H:i:s'),
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'phone_number' => $_POST['phone_number'],
            'address' => $_POST['address'],
            'receiver_name' => $_POST['receiver_name'],
            // 'voucher_code' => $_SESSION['voucherCode'] ?? null,
            // 'discount' => $discount,
        ]);
        if (!$orderId) {
            $_SESSION['error'] = 'Không tạo được đơn hàng. Vui lòng thử lại!';
            header('Location: /duan1_final/user/payment');
            exit;
        }

        // Lưu chi tiết đơn hàng + trừ tồn kho
        $orderDetail = new OrderDetail();
        $productModel = new Product();

        foreach ($cart as $item) {
            $orderDetail->create([
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price']
            ]);

            $productModel->decreaseStock($item['product_id'], $item['quantity']);
        }

        // Xóa giỏ hàng và voucher sau khi đặt hàng
        unset($_SESSION['cart'], $_SESSION['discount'], $_SESSION['voucherCode']);
        $_SESSION['success'] = 'Đặt hàng thành công!';
        header('Location: /duan1_final/user');
        exit;
    }


    public function applyVoucher()
    {
        // Lưu dữ liệu form trước khi xử lý voucher
        $_SESSION['formData'] = [
            'receiver_name' => $_POST['receiver_name'] ?? '',
            'phone_number' => $_POST['phone_number'] ?? '',
            'address' => $_POST['address'] ?? '',
            'province' => $_POST['province'] ?? '',
            'district' => $_POST['district'] ?? '',
            'ward' => $_POST['ward'] ?? '',
        ];

        $code = $_POST['voucher'] ?? '';

        if (empty($code)) {
            $_SESSION['error'] = 'Vui lòng nhập mã giảm giá!';
            header('Location: /duan1_final/user/payment');
            exit;
        }

        $promotionModel = new \App\Models\Promotion();
        $promotion = $promotionModel->getByCode($code);

        if (!$promotion) {
            $_SESSION['error'] = 'Mã giảm giá không hợp lệ hoặc đã hết hạn!';
        } else {
            if ($promotion['apply_type'] === 'order') {
                $_SESSION['discount'] = $promotion['discount_percentage'];
                $_SESSION['voucherCode'] = $code;
                $_SESSION['success'] = 'Áp dụng mã giảm giá thành công!';
            } else {
                $_SESSION['error'] = 'Mã giảm giá này không áp dụng cho toàn bộ đơn hàng!';
            }
        }

        header('Location: /duan1_final/user/payment');
        exit;
    }

}
