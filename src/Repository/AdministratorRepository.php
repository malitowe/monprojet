<?php

namespace App\Repository;

use App\Entity\Administrator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use \Doctrine\ORM\QueryBuilder;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


class AdministratorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Administrator::class);
    }

    /**
    * @param string $alias
    * @return \Doctrine\ORM\QueryBuilder
    */
    private function getBuilder($alias = 'u')
    {
        return $this->createQueryBuilder($alias);
    }

    public function getUserByIdentifierQueryBuilder(QueryBuilder &$qb, $identifier)
    {
        $qb->andWhere(
            $qb->expr()->orX(
                    'u.username = :identifier', 'u.email = :identifier'
                )
            )
            ->setParameter('identifier', $identifier);

        return $this;
    }

    public function findUserByUsernameOrEmail($identifier)
    {
        $qb = $this->getBuilder();
        $this->getUserByIdentifierQueryBuilder($qb, $identifier);

        return $qb->getQuery()->getOneOrNullResult();
    }
   /*
    public function updateUser(Administrateur $admin, $andFlush = true)
    {
         $em->persist($admin);
        if ($andFlush) {
            $this->ObjectManager()->flush();
        }
    }
*/
    /**
     * {@inheritdoc}
     */
    public function findUserByConfirmationToken($token)
    {
        return $this->findUserBy(array('confirmationToken' => $token));
    }

    /**
     * {@inheritdoc}
     */
    public function findUserBy(array $criteria)
    {
        return $this->findOneBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function findAllUserByRole($role, $get_qb = true)
    {
        $qb = $this->getBuilder();
        $qb->where($qb->expr()->like('u.roles', ':roles'))
            ->setParameter('roles', '%"'.$role.'"%');
        if($get_qb)
            return $qb;

        return $qb->getQuery()->getResult();
    }

}
