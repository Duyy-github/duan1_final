<?php
// theo dõi đơn hàng của người dùng
namespace App\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;

class UserOrderController
{
    protected $order;
    protected $orderDetail;

    public function __construct()
    {
        $this->order = new Order();
        $this->orderDetail = new OrderDetail();
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
        // if (!$userId) {
        //     $_SESSION['error'] = 'Bạn cần đăng nhập!';
        //     header('Location: /duan1_final/login');
        //     exit;
        // }

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

    public function cancel($id)
    {
        $orderModel = new Order();
        $order = $orderModel->find($id);

        // Kiểm tra quyền: người dùng chỉ được hủy đơn hàng của chính mình (nếu bạn có user_id)
        if (!$order || $order['user_id'] != $_SESSION['user']['id']) {
            $_SESSION['flash']['danger'] = 'Không tìm thấy đơn hàng hoặc bạn không có quyền.';
            header('Location: ' . route('user/orders'));
            exit;
        }

        // Chỉ được hủy khi đơn hàng đang chờ hoặc đang xử lý
        if (!in_array($order['status'], ['pending', 'processing'])) {
            $_SESSION['flash']['warning'] = 'Không thể hủy đơn hàng ở trạng thái hiện tại.';
            header('Location: ' . route('user/orders/show/' . $id));
            exit;
        }

        // Cập nhật trạng thái thành cancelled
        $orderModel->update($id, ['status' => 'cancelled']);

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

        $this->order->update($id, ['status' => 'completed']);

        $_SESSION['flash']['success'] = 'Bạn đã xác nhận đã nhận hàng thành công.';
        header('Location: ' . route('user/orders/show/' . $id));
        exit;
    }

}
