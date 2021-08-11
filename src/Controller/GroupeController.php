<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Form\GroupeType;
use App\Repository\GroupeRepository;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/groupe", name="groupe_")
 */
class GroupeController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(GroupeRepository $groupeRepository, ParticipantRepository $participantRepository): Response
    {
        $groupes = $groupeRepository->findAllByUser($participantRepository->findOneBy(["email" => $this->getUser()->getUsername()])->getId());
        return $this->render('groupe/index.html.twig',[
            "groupes" => $groupes
        ]);
    }

    /**
     * @Route("/ajouter-groupe", name="ajouter-groupe")
     */
    public function ajouterGroupe(Request $request, EntityManagerInterface $em, ParticipantRepository $participantRepository): Response
    {
        $groupe = new Groupe();
        $groupe->setOrganisateur($participantRepository->findOneBy(["email" => $this->getUser()->getUsername()]));
        $form = $this->createForm(GroupeType::class, $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($groupe);
            $em->flush();

            $this->addFlash('message', 'Groupe ajouté');
            return $this->redirectToRoute('groupe_main');
        }
        return $this->render('groupe/createGroup.html.twig',[
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/ajouter-membre/{id}", name="ajouter-membre")
     */
    public function ajouterMembre($id, ParticipantRepository $participantRepository, GroupeRepository $groupeRepository): Response
    {
        $membres = $participantRepository->findAll();
        $groupe = $groupeRepository->find($id);

        return $this->render('groupe/addMembre.html.twig',[
            "membres" => $membres,
            "groupe" => $groupe
        ]);
    }

    /**
     * @Route("/inscription/{idGroupe}/{idMembre}", name="ajouter-membre-group")
     */
    public function ajouterMembreGroupe($idMembre,$idGroupe, EntityManagerInterface $entityManager, Request $request, ParticipantRepository $participantRepository, GroupeRepository $groupeRepository): Response
    {
        $membre = $participantRepository->find($idMembre);
        $groupe = $groupeRepository->find($idGroupe);

        $groupe->addParticipant($membre);
        $entityManager->persist($membre);
        $entityManager->flush();

        return $this->redirectToRoute('groupe_ajouter-membre',["id"=>$idGroupe]);
    }

    /**
     * @Route("/supression/{idGroupe}/{idMembre}", name="supprimer-membre-group")
     */
    public function suprimmerMembreGroupe($idMembre, $idGroupe, EntityManagerInterface $entityManager, Request $request, ParticipantRepository $participantRepository, GroupeRepository $groupeRepository): Response
    {
        $membre = $participantRepository->find($idMembre);
        $groupe = $groupeRepository->find($idGroupe);

        $groupe->removeParticipant($membre);
        $entityManager->persist($membre);
        $entityManager->flush();

        return $this->redirectToRoute('groupe_ajouter-membre',["id"=>$idGroupe]);
    }

    /**
     * @Route("/supressionGroupe/{idGroupe}", name="suprimer-group")
     */
    public function supprimerGroupe($idGroupe, EntityManagerInterface $entityManager, Request $request, ParticipantRepository $participantRepository, GroupeRepository $groupeRepository): Response
    {
        $groupe = $groupeRepository->find($idGroupe);

        $entityManager->remove($groupe);
        $entityManager->flush();

        return $this->redirectToRoute('groupe_main');
    }
}
