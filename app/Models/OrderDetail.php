<?php
namespace App\Models;
use App\Models\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    public function create($data)
    {
        return $this->insert($data);
    }
    public function getDetailsByOrderId($orderId)
    {
        $query = $this->connection->createQueryBuilder()
            ->select('od.*', 'p.product_name', 'p.price', 'p.image')
            ->from($this->table, 'od')
            ->innerJoin('od', 'products', 'p', 'od.product_id = p.product_id')
            ->where('od.order_id = :orderId')
            ->setParameter('orderId', $orderId);

        return $query->fetchAllAssociative();
    }
    public function getOrderItems($orderId)
    {
        $query = $this->connection->createQueryBuilder()
            ->select('oi.*, p.name as product_name, p.image, p.price')
            ->from('order_items', 'oi')
            ->join('oi', 'products', 'p', 'oi.product_id = p.id')
            ->where('oi.order_id = :orderId')
            ->setParameter('orderId', $orderId);

        return $query->fetchAllAssociative();
    }
}