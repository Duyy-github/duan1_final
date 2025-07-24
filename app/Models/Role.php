<?php
namespace App\Models;
use App\Models\Model;

class Role extends Model
{
    public function getAll()
    {
        $query = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('roles')
            ->orderBy('role_id', 'DESC');
        return $query->fetchAllAssociative();
    }

}