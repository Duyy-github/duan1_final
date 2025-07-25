<?php
namespace App\Models;
use App\Models\Model;

class Product extends Model
{
    public function getAll()
    {
        $query = $this->connection->createQueryBuilder()
            ->select('p.*', 'c.category_name AS category_name')
            ->from('products', 'p')
            ->innerJoin('p', 'categories', 'c', 'p.category_id = c.category_id')
            ->orderBy('p.product_id', 'DESC');
        return $query->fetchAllAssociative();
    }

    public function findById($id)
    {
        $query = $this->connection->createQueryBuilder();

        $query->select('p.*', 'c.category_name AS category_name')
            ->from('products', 'p')
            ->innerJoin('p', 'categories', 'c', 'p.category_id = c.category_id')
            ->where('p.product_id = :id');
        $query->setParameter('id', $id);

        return $query->fetchAssociative();
    }

    //thêm sản phẩm từ form vào csdl
    public function insert($data)
    {
        return $this->connection->insert('products', [
            'product_name' => $data['product_name'],
            'image' => $data['image'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'category_id' => $data['category_id'],
            'description' => $data['description'],
            'import_date' => $data['import_date'],
        ]);
    }

    public function update($id, $data)
    {
        return $this->connection->update('products', [
            'product_name' => $data['product_name'],
            'image' => $data['image'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'category_id' => $data['category_id'],
            'description' => $data['description'],
            'import_date' => $data['import_date'],
        ], [
            'product_id' => $id,
        ]);
    }
    public function delete($id)
    {
        return $this->connection->delete('products', [
            'product_id' => $id,
        ]);
    }
}