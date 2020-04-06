<?php

declare(strict_types=1);

namespace AMoretti\PhpTest\ABTesting;

use AMoretti\PhpTest\Database\AbstractRepository;

class PromotionAccessRepository extends AbstractRepository
{
    protected string $table = 'promotion_design_access';

    public function save(PromotionAccessEntity $promotionDesign)
    {
        if (\count($promotion = $this->findBy(['ip' => $promotionDesign->getIp()]))) {
            return;
        }

        $binds = [
            'ip' => $promotionDesign->getIp(),
            'promotion_design_id' => $promotionDesign->getDesignId(),
        ];

        $this->insert($binds);
    }
}
