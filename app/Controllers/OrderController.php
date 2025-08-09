<?php
namespace App\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Controllers\Controller;

class OrderController extends Controller
{
    private $orderModel;
    private $orderDetailModel;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->orderDetailModel = new OrderDetail();
    }

    public function index()
    {
        $orders = $this->orderModel->getAll();
        return view('Staff.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = $this->orderModel->findById($id);
        if (!$order) {
            setFlash('error', 'Không tìm thấy đơn hàng');
            redirect('staff/orders');
        }
        $orderDetails = $this->orderDetailModel->getDetailsByOrderId($id);
        return view('Staff.orders.show', compact('order', 'orderDetails'));
    }

    public function updateStatus()
    {
        $orderId = $_POST['order_id'] ?? null;
        $status = $_POST['status'] ?? 'pending';

        if ($orderId && $this->orderModel->updateStatus($orderId, $status)) {
            setFlash('success', 'Cập nhật trạng thái thành công!');
        } else {
            setFlash('error', 'Cập nhật trạng thái thất bại!');
        }
        redirect('staff/orders');
    }


}