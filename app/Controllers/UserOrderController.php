<?php
namespace App\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;

class UserOrderController
{
    protected $order;
    protected $orderDetail;
    protected $product;

    public function __construct()
    {
        $this->order = new Order();
        $this->orderDetail = new OrderDetail();
        $this->product = new Product();
    }

    // Danh sách đơn hàng của người dùng hiện tại
    public function index()
    {
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            $_SESSION['error'] = 'Bạn cần đăng nhập để xem đơn hàng!';
            header('Location: /duan1_final/login');
            exit;
        }

        $orders = $this->order->getByUserId($userId);

        return view('User.orders', [
            'orders' => $orders
        ]);
    }

    // Chi tiết đơn hàng
    public function show($orderId)
    {
        $userId = $_SESSION['user']['id'] ?? null;

        $order = $this->order->findById($orderId);
        if (empty($order) || $order['user_id'] != $userId) {
            $_SESSION['error'] = 'Không tìm thấy đơn hàng!';
            header('Location: /duan1_final/user/orders');
            exit;
        }

        $details = $this->orderDetail->getDetailsByOrderId($orderId);
        return view('User.order_detail', [
            'order' => $order,
            'details' => $details
        ]);
    }

    // Hủy đơn hàng
    public function cancel($id)
    {
        $order = $this->order->find($id);

        if (!$order || $order['user_id'] != $_SESSION['user']['id']) {
            $_SESSION['flash']['danger'] = 'Không tìm thấy đơn hàng hoặc bạn không có quyền.';
            header('Location: ' . route('user/orders'));
            exit;
        }

        if (!in_array($order['status'], ['pending', 'processing'])) {
            $_SESSION['flash']['warning'] = 'Không thể hủy đơn hàng ở trạng thái hiện tại.';
            header('Location: ' . route('user/orders/show/' . $id));
            exit;
        }

        // Cập nhật trạng thái thành cancelled
        $this->order->update($id, ['status' => 'cancelled']);

        // Hoàn lại tồn kho
        $details = $this->orderDetail->getDetailsByOrderId($id);
        foreach ($details as $detail) {
            $this->product->increaseStock($detail['product_id'], $detail['quantity']);
        }

        $_SESSION['flash']['success'] = 'Đơn hàng đã được hủy thành công.';
        header('Location: ' . route('user/orders/show/' . $id));
        exit;
    }

    // Xác nhận đã nhận hàng
    public function markAsReceived($id)
    {
        $order = $this->order->find($id);

        if (!$order || $order['user_id'] != $_SESSION['user']['id']) {
            $_SESSION['flash']['danger'] = 'Không tìm thấy đơn hàng hoặc bạn không có quyền.';
            header('Location: ' . route('user/orders'));
            exit;
        }

        if ($order['status'] !== 'delivering') {
            $_SESSION['flash']['warning'] = 'Đơn hàng không thể xác nhận trong trạng thái hiện tại.';
            header('Location: ' . route('user/orders/show/' . $id));
            exit;
        }

        $this->order->update($id, ['status' => 'delivered']);

        $_SESSION['flash']['success'] = 'Bạn đã xác nhận đã nhận hàng thành công.';
        header('Location: ' . route('user/orders/show/' . $id));
        exit;
    }

    // Trả hàng
    public function returnOrder($id)
    {
        $order = $this->order->find($id);

        if (!$order || $order['user_id'] != $_SESSION['user']['id']) {
            $_SESSION['flash']['danger'] = 'Không tìm thấy đơn hàng hoặc bạn không có quyền.';
            header('Location: ' . route('user/orders'));
            exit;
        }

        if ($order['status'] !== 'delivered') {
            $_SESSION['flash']['warning'] = 'Không thể yêu cầu trả hàng ở trạng thái hiện tại.';
            header('Location: ' . route('user/orders/show/' . $id));
            exit;
        }

        $this->order->update($id, ['status' => 'returned']);

        // +++ Hoàn lại tồn kho
        $details = $this->orderDetail->getDetailsByOrderId($id);
        foreach ($details as $detail) {
            $this->product->increaseStock($detail['product_id'], $detail['quantity']);
        }

        $_SESSION['flash']['success'] = 'Yêu cầu trả hàng đã được gửi thành công.';
        header('Location: ' . route('user/orders/show/' . $id));
        exit;
    }

    // Hoàn thành đơn hàng
    public function complete($id)
    {
        $order = $this->order->find($id);

        if (!$order || $order['user_id'] != $_SESSION['user']['id']) {
            $_SESSION['flash']['danger'] = 'Không tìm thấy đơn hàng hoặc bạn không có quyền.';
            header('Location: ' . route('user/orders'));
            exit;
        }

        if ($order['status'] !== 'delivered') {
            $_SESSION['flash']['warning'] = 'Đơn hàng không thể hoàn thành ở trạng thái hiện tại.';
            header('Location: ' . route('user/orders/show/' . $id));
            exit;
        }

        $this->order->update($id, ['status' => 'completed']);

        $_SESSION['flash']['success'] = 'Đơn hàng đã được hoàn thành thành công.';
        header('Location: ' . route('user/orders/show/' . $id));
        exit;
    }
}
