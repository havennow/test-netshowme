<?php

declare(strict_types=1);

namespace App\Email\Persistence\Repository;

use App\Email\Domain\Entity\Email;
use App\Email\Domain\Repository\EmailRepository;
use App\Email\Domain\Exceptions\RecordExistException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class EmailOrmRepository
 * @package App\Email\Persistence\Repository
 */
class EmailOrmRepository implements EmailRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    /**
     * @param Email $email
     * @return bool
     * @throws \Exception
     */
    public function save(Email $email): bool
    {
        $exist = $this->findBy(['email' => $email->getEmail()]);

        if ($exist) {
            throw new RecordExistException();
        }

        try {
            $this->entityManager->persist($email);
            $this->entityManager->flush();

            return true;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function find(int $id)
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('e')
            ->from(Email::class, 'e')
            ->where('e.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param array $filters
     * @return array
     */
    public function findBy(array $filters = []): array
    {
        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('e')
            ->from(Email::class, 'e');

        if (isset($filters['name'])) {
            $query->andWhere($query->expr()->like('e.name',$query->expr()->literal('%' . $filters['name'] . '%')));
        }

        if (isset($filters['email'])) {
            $query->andWhere($query->expr()->like('e.email',$query->expr()->literal('%' . $filters['email'] . '%')));
        }

        return $query->getQuery()->getArrayResult();
    }
}
