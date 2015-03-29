<?php
/**
 * Created by PhpStorm.
 * User: Jan
 * Date: 28.03.2015
 * Time: 10:02
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ConversationRepository extends EntityRepository{
    public function findAllByUserId($user_id)
    {
        $repository = $this->getEntityManager()
            ->getRepository('AppBundle:Conversation');

        $query = $repository->createQueryBuilder('c')
            ->where('c.user_one = :id')
            ->orWhere('c.user_two = :id')
            ->setParameter('id', $user_id)
            ->getQuery();
        return $query->getResult();
    }
}