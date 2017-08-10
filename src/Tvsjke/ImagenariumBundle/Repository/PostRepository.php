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
    $queryBuilder = $this->createQueryBuilder('p');
    $query = $queryBuilder->orderBy('p.id', 'DESC')->getQuery();

    return $this->createPaginator($query, $page);
  }

  private function createPaginator(Query $query, $page)
  {
    $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
    $paginator->setMaxPerPage(Post::NUM_ITEMS);
    $paginator->setCurrentPage($page);

    return $paginator;
  }

  /**
   * @param string $rawQuery
   * @param int    $limit
   *
   * @return array
   */
  public function findBySearchQuery($rawQuery, $limit = Post::NUM_ITEMS)
  {
    $query = $this->sanitizeSearchQuery($rawQuery);
    $searchTerms = $this->extractSearchTerms($query);
    if (0 === count($searchTerms)) {
      return [];
    }
    $queryBuilder = $this->createQueryBuilder('p');
    foreach ($searchTerms as $key => $term) {
      $queryBuilder
        ->orWhere('p.title LIKE :t_'.$key)
        ->setParameter('t_'.$key, '%'.$term.'%')
      ;
    }
    return $queryBuilder
      ->orderBy('p.id', 'DESC')
      ->setMaxResults($limit)
      ->getQuery()
      ->getResult();
  }

  /**
   *
   * @param string $query
   *
   * @return string
   */
  private function sanitizeSearchQuery($query)
  {
    return preg_replace('/[^[:alnum:] ]/', '', trim(preg_replace('/[[:space:]]+/', ' ', $query)));
  }

  /**
   *
   * @param string $searchQuery
   *
   * @return array
   */
  private function extractSearchTerms($searchQuery)
  {
    $terms = array_unique(explode(' ', mb_strtolower($searchQuery)));
    return array_filter($terms, function ($term) {
      return 2 <= mb_strlen($term);
    });
  }
}