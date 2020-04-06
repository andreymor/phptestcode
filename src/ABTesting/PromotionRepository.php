<?php

declare(strict_types=1);

namespace AMoretti\PhpTest\ABTesting;

use AMoretti\PhpTest\Database\AbstractRepository;

class PromotionRepository extends AbstractRepository
{
    protected string $table = 'promotion_design';

    public function loadAll(): array
    {
        $data = $this->fetchAll();

        $promotions = [];
        foreach ($data as $column => $value) {
            $promotions[$value['id']] = [
                $value['design_name'] => $value['split_percent'],
            ];
        }

        return $promotions;
    }
}
