<?php
namespace App\Models;
use App\Models\Model;

class User extends Model
{
    public function getAll()
    {
        $query = $this->connection->createQueryBuilder()
            ->select('u.*', 'r.role_name AS role_name')
            ->from('users', 'u')
            ->innerJoin('u', 'roles', 'r', 'u.role_id = r.role_id')
            ->orderBy('u.user_id', 'DESC');
        return $query->fetchAllAssociative();
    }
    public function findById($id)
    {
        $query = $this->connection->createQueryBuilder();

        $query->select('u.*')
            ->from('users', 'u')
            ->where('u.user_id = :id');
        $query->setParameter('id', $id);

        return $query->fetchAssociative();
    }
    public function updateStatus($id, $status)
    {
        $query = $this->connection->createQueryBuilder();

        $query->update('users')
            ->set('status', ':status')
            ->where('user_id = :id')
            ->setParameter('status', $status)
            ->setParameter('id', $id);

        return $query->executeStatement();
    }
}