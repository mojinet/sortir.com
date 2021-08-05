<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    /**
     * @param $id
     * @return Sortie
     */
    public function detailSortie($id){
        $query = $this
            ->createQueryBuilder('s')
            ->select('s', 'p', 'e', 'c', 'l', 'v')
            ->join('s.participants', 'p')
            ->join('s.etat', 'e')
            ->join('s.campus', 'c')
            ->join('s.lieu', 'l')
            ->join('l.ville', 'v')
            ->andWhere('s.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getSingleResult();
        return $query;
    }

    public function listSortie(){
        $query = $this
            ->createQueryBuilder('s')
            ->select('s', 'p', 'e')
            ->join('s.participants', 'p')
            ->join('s.etat', 'e')
            ->getQuery()
            ->getResult();
        return $query;
    }


    public function search($mots){
        $query = $this
            ->createQueryBuilder('s');
//            ->where('s.active = 1');
        if($mots != null){
            $query->where('MATCH_AGAINST(s.nom, s.infosSortie) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots);
        }
        return $query->getQuery()->getResult();


    }
}
