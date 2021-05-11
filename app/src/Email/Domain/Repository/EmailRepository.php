<?php

declare(strict_types=1);

namespace App\Email\Domain\Repository;

use App\Email\Domain\Entity\Email;

/**
 * Interface EmailRepository
 * @package App\Email\Domain\Repository
 */
interface EmailRepository
{
    /**
     * @param Email $email
     * @return bool
     */
    public function save(Email $email): bool;

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param array $filters
     * @return array
     */
    public function findBy(array $filters = []): array;
}
