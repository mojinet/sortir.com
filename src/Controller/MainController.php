<?php

namespace App\Controller;

use App\Form\FilterType;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/",name="main_")
 */
class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SortieRepository $sortieRepository): Response
    {
        // recupere la liste de toutes les sorties
        $sorties = $sortieRepository->findAll();

        // determine si l'utilisateur connecter participe au sortie affiché
        foreach ($sorties as $sortie){
            // convertie l'arrayCollection en simple array
            $participantsArray = $sortie->getParticipants()->toArray();
            $imIn[$sortie->getId()] = false;
            // recherche si notre user est contenu dans la liste des participants
            if( in_array($this->getUser(), $participantsArray)){
                $imIn[$sortie->getId()] = true;
            }
        }

        //formulaire pour filtre
        $filterForm = $this->createForm(FilterType::class);

        return $this->render('main/index.html.twig', [
            "sorties" => $sorties,
            "imIn" =>  $imIn,
            "filterForm" => $filterForm->createView()
        ]);
    }

    /**
     * @Route("/participer/{id}", name="participe")
     */
    public function participer($id, EntityManagerInterface $em, SortieRepository $sortieRepository, ParticipantRepository $participantRepository)
    {
        $sortie = $sortieRepository->find($id);
        $sortie->addParticipant($participantRepository->findOneBy(["email" => $this->getUser()->getUsername()]));

        $em->persist($sortie);
        $em->flush();
        return $this->redirectToRoute('main_home');
    }

    /**
     * @Route("/desister/{id}", name="desister")
     */
    public function desister($id, EntityManagerInterface $em, SortieRepository $sortieRepository, ParticipantRepository $participantRepository)
    {
        $sortie = $sortieRepository->find($id);
        $sortie->removeParticipant($participantRepository->findOneBy(["email" => $this->getUser()->getUsername()]));

        $em->persist($sortie);
        $em->flush();
        return $this->redirectToRoute('main_home');
    }
}
