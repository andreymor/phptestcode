<?php

declare(strict_types=1);

namespace AMoretti\PhpTest\ABTesting;

class PromotionAccessEntity
{
    protected string $name;
    protected string $ip;
    protected int $designId;

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return PromotionAccessEntity
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @return PromotionAccessEntity
     */
    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getDesignId(): int
    {
        return $this->designId;
    }

    /**
     * @return PromotionAccessEntity
     */
    public function setDesignId(int $designId): self
    {
        $this->designId = $designId;

        return $this;
    }
}
