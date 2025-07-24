<?php
namespace App\Models;
use App\Models\Model;

class Category extends Model
{
    public function getAll()
    {
        $query = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('categories')
            ->orderBy('category_id', 'DESC');
        return $query->fetchAllAssociative();
    }
    public function insert($data)
    {
        return $this->connection->insert('categories', [
            'category_name' => $data['category_name'],
        ]);
    }
    public function delete($id)
    {
        return $this->connection->delete('categories', [
            'category_id' => $id,
        ]);
    }
}