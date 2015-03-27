<?php
/**
 * Created by PhpStorm.
 * User: Jan
 * Date: 17.03.2015
 * Time: 17:03
 */
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ThreadRepository extends EntityRepository
{
    public function findAllOrderedByLastModifiedDate($category_id)
    {
        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:Thread');

        $query = $repository->createQueryBuilder('t')
            ->where("t.category = :id")
            ->setParameter('id', $category_id)
            ->orderBy('t.last_modified_date', 'desc')
            ->getQuery();
        return $query;
    }

    public function findAllPostsOrderedById($thread_id)
    {
        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:Post');

        $query = $repository->createQueryBuilder('p')
            ->where("p.thread = :id")
            ->setParameter('id', $thread_id)
            ->getQuery();
        return $query;
    }
}