<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Ville;
use App\Form\LieuType;
use App\Form\VilleType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/sortie/details/{id}", name="sortie_details")
     */
    public function details(int $id, SortieRepository $sortieRepository): Response
    {
        $sortie = $sortieRepository->find($id);

        return $this->render('sortie/details.html.twig', [

            "sortie" => $sortie

        ]);
    }

    /**
     * @Route("/sortie/ajouter/ville", name="sortie_ajouter_ville")
     */
    public function ajouterVille(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ville = new Ville();
        $villeForm = $this->createForm(VilleType::class,$ville);
        $villeForm->handleRequest($request);

        if($villeForm->isSubmitted() && $villeForm->isValid()){
            $entityManager->persist($ville);
            $entityManager->flush();

            return $this->redirectToRoute('main_home');
        }

        return $this->render('sortie/ajouterVille.html.twig',[
            'villeForm' => $villeForm->createView()
        ]);
    }

    /**
     * @Route("/sortie/ajouter/lieu", name="sortie_ajouter_lieu")
     */
    public function ajouterLieu(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lieu = new Lieu();
        $lieuForm = $this->createForm(LieuType::class,$lieu);
        $lieuForm->handleRequest($request);

        if($lieuForm->isSubmitted()){
            $entityManager->persist($lieu);
            $entityManager->flush();

            return $this->redirectToRoute('main_home');
        }

        return $this->render('sortie/ajouterLieu.html.twig',[
            'lieuForm' => $lieuForm->createView()
        ]);
    }
}
