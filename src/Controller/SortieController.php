<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Form\LieuType;
use App\Form\SortieType;
use App\Form\VilleType;
use App\Repository\CampusRepository;
use App\Repository\EtatRepository;
use App\Repository\LieuRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
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

    /**
     * @Route("/sortie/create", name="sortie_create")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param CampusRepository $campusRepository
     * @param LieuRepository $lieuRepository
     * @param EtatRepository $etatRepository
     * @param $participantRepository
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $entityManager, CampusRepository $campusRepository, LieuRepository $lieuRepository, EtatRepository $etatRepository, ParticipantRepository $participantRepository): Response
    {
        $sortie = new Sortie();
        $sortieForm = $this->createForm(SortieType::class, $sortie);

        $etat = $etatRepository->findAll()[0];
        $sortie->setEtat($etat);

        //récupérer l'utilisateur
        $user = $participantRepository->findOneBy(["email" => $this->getUser()->getUsername()]);


        //associé id utilisateur campus à la sortie
        $sortie->setCampus($user->getCampus());
        $sortie->setOrganisateur($user);



        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()){



            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('success', 'La sortie a bien été créer');
            return $this->redirectToRoute('sortie_details', ['id' => $sortie->getId()]);
        }

        //todo traiter le formulaire

        return $this->render('sortie/create.html.twig', [
            'sortieForm' => $sortieForm->createView()
        ]);
    }
}
