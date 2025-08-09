<?php
namespace App\Models;
use App\Models\Model;

class Order extends Model
{
    protected $table = 'orders';

    public function create($data)
    {
        // Thêm đơn hàng mới, trả về ID vừa tạo
        return $this->insert($data);
    }
    public function getAll()
    {
        $query = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->table)
            ->orderBy('order_id', 'DESC');
        return $query->fetchAllAssociative();
    }

    public function findById($id)
    {
        $query = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->table)
            ->where('order_id = :id')
            ->setParameter('id', $id);

        return $query->fetchAssociative() ?: [];
    }

    public function updateStatus($orderId, $status)
    {
        try {
            $this->connection->update($this->table, ['status' => $status], ['order_id' => $orderId]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    // Lấy danh sách đơn hàng của người dùng theo user_id
    public function getByUserId($userId)
    {
        $query = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->table)
            ->where('user_id = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('order_id', 'DESC');

        return $query->fetchAllAssociative();
    }

    public function find($id)
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->table)
            ->where('order_id = ?')
            ->setParameter(0, $id)
            ->executeQuery()
            ->fetchAssociative();
    }

    public function update($id, $data)
    {
        return $this->connection->update($this->table, $data, ['order_id' => $id]);
    }
}