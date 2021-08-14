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
            ->select('s','p', 'e')
            ->leftJoin('s.participants', 'p')
            ->leftJoin('s.etat', 'e')
            ->getQuery()
            ->getResult();
        return $query;
    }


    public function search($mots = null , $campus = null, $organisateur = false, $id, $inscrit = false, $pasInscrit = false, $dejaPasse = false, $dateHeureDebut = null, $dateLimiteInscription = null){

        $query = $this
            ->createQueryBuilder('s');
        if($mots != null){
            //todo : duplicate key à cause de ça, voir pour retablir autrement
//            $query->where('MATCH_AGAINST(s.nom, s.infosSortie) AGAINST (:mots boolean)>0')
//                ->setParameter('mots', $mots);
        }
        if($campus != null){
            $query->leftJoin('s.campus', 'c');
            $query->andWhere('c.id = :id')
                ->setParameter('id', $campus);
        }
        if($organisateur){
            $query->andWhere('s.organisateur = :id')
                ->setParameter('id', $id);
        }
        if($inscrit){
            $query->innerJoin('s.participants', 'p');
            $query->andWhere('p.id = :id')
                ->setParameter('id', $id);
        }
        if($pasInscrit){
            $query->innerJoin('s.participants', 'p');
            $query->andWhere('p.id != :id')
                ->setParameter('id', $id);
        }
        if($dejaPasse){
            $query->andWhere('s.etat = 8 ');
        }
        if($dateHeureDebut != null){
            $query->andWhere('s.dateHeureDebut > :dateHeureDebut')
                ->setParameter('dateHeureDebut', $dateHeureDebut);
            $query->orderBy('s.dateHeureDebut', 'ASC');
        }
        if($dateLimiteInscription != null){
            $query->andWhere('s.dateLimiteInscription > :dateLimiteInscription')
                ->setParameter('dateLimiteInscription', $dateLimiteInscription);
            $query->orderBy('s.dateHeureDebut', 'ASC');
        }
        return $query->getQuery()->getResult();


    }
}
