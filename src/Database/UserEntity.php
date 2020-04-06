<?php

declare(strict_types=1);

namespace AMoretti\PhpTest\Database;

class UserEntity
{
    protected string $name;
    protected string $jobTitle;
    protected int $age;

    /**
     * @return mixed
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return UserEntity
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getJobTitle(): string
    {
        return $this->jobTitle;
    }

    /**
     * @param mixed $jobTitle
     *
     * @return UserEntity
     */
    public function setJobTitle(string $jobTitle): self
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     *
     * @return UserEntity
     */
    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }
}
