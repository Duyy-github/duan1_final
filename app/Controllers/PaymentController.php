<?php
namespace App\Controllers;
use App\Models\Order;
use App\Models\OrderDetail;

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

        return view('User.payment', [
            'cart' => $cart,
            'totalItems' => $totalItems,
            'totalPrice' => $totalPrice,
        ]);
    }

    // Xử lý đặt hàng
    public function submit()
    {
        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            $_SESSION['error'] = 'Giỏ hàng trống!';
            header('Location: /duan1_final/user/payment');
            exit;
        }

        // Tính tổng tiền từ server (không dựa vào client)
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Kiểm tra thông tin bắt buộc
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
            'receiver_name' => $_POST['receiver_name']
        ]);

        // Lưu chi tiết đơn hàng
        $orderDetail = new OrderDetail();
        foreach ($cart as $item) {
            $orderDetail->create([
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price']
            ]);
        }

        // Xóa giỏ hàng sau khi đặt hàng
        unset($_SESSION['cart']);
        $_SESSION['success'] = 'Đặt hàng thành công!';
        header('Location: /duan1_final/user');
        exit;
    }

}