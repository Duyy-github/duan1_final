<?php
namespace App\Models;

use App\Models\Model;

class Promotion extends Model
{
    protected $table = 'promotions';

    public function getAll()
    {
        $query = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->table);
        return $query->fetchAllAssociative();
    }

    public function create($data)
    {
        $query = $this->connection->createQueryBuilder()
            ->insert($this->table)
            ->values([
                'name' => '?',
                'discount_percentage' => '?',
                'start_date' => '?',
                'end_date' => '?',
                'apply_type' => '?',
                'product_id' => '?'
            ])
            ->setParameter(0, $data['name'])
            ->setParameter(1, $data['discount_percentage'])
            ->setParameter(2, $data['start_date'])
            ->setParameter(3, $data['end_date'])
            ->setParameter(4, $data['apply_type'])
            ->setParameter(5, $data['product_id'] ?? null);

        return $query->executeStatement();
    }
    public function delete($id)
    {
        return $this->connection->delete($this->table, ['promotion_id' => $id]);
    }

    public function getByCode($code)
    {
        $query = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->table)
            ->where('name = :code')
            ->andWhere('start_date <= CURRENT_DATE()')
            ->andWhere('end_date >= CURRENT_DATE()')
            ->setParameter('code', $code);
        return $query->fetchAssociative();
    }

    public function isValidForProducts($promotion, $productIds)
    {
        if (empty($promotion['product_id'])) {
            return true;
        }
        return in_array($promotion['product_id'], $productIds);
    }
}