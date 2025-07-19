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
}