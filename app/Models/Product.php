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

        $query->select('p.*', 'c.name AS category_name')
            ->from('products', 'p')
            ->innerJoin('p', 'categories', 'c', 'p.category_id = c.id')
            ->where('p.id = :id');
        $query->setParameter('id', $id);

        return $query->fetchAssociative();
    }
}