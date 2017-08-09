<?php

namespace Tvsjke\ImagenariumBundle\Repository;

use Tvsjke\ImagenariumBundle\Entity\Post;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class PostRepository extends EntityRepository
{
  /**
   * @param int $page
   *
   * @return Pagerfanta
   */
  public function findLatest($page = 1)
  {
    $query = $this->getEntityManager()->createQuery('SELECT p FROM ImagenariumBundle:Post p ORDER BY p.id DESC');

    return $this->createPaginator($query, $page);
  }

  private function createPaginator(Query $query, $page)
  {
    $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
    $paginator->setMaxPerPage(Post::NUM_ITEMS);
    $paginator->setCurrentPage($page);
    return $paginator;
  }
}