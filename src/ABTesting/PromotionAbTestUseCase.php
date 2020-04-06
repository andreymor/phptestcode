<?php

declare(strict_types=1);

namespace AMoretti\PhpTest\ABTesting;

\session_start();

/**
 * Perform an AB testing and also persist the current data on DB to provide metrics
 */
class PromotionAbTestUseCase
{
    protected Test $test;

    public function __construct()
    {
        $variations = (new PromotionRepository())->loadAll();
        $this->test = new Test($variations);
        $this->createSeed();
    }

    protected function createSeed(): void
    {
        if (!isset($_SESSION['user_ab_test_seed'])) {
            $_SESSION['user_ab_test_seed'] = \mt_rand();
        }

        $this->test->setSeed($_SESSION['user_ab_test_seed']);
    }

    public function run(): Test
    {
        $this->test->execute();
        $this->save();

        return $this->test;
    }

    protected function save(): void
    {
        $promotionAccess = (new PromotionAccessEntity())
            ->setName($this->test->getVariationName())
            ->setIp($_SERVER['REMOTE_ADDR'])
            ->setDesignId($this->test->getVariationId());

        (new PromotionAccessRepository())->save($promotionAccess);
    }
}
