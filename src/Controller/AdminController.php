<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\AddMemberCSVType;
use App\Repository\CampusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/ajouterMembre", name="admin_main")
     */
    public function addMember(Request $request, EntityManagerInterface $entityManager, CampusRepository $campusRepository,UserPasswordEncoderInterface $encoder): Response
    {
        // on renvois un formulaire
        $form = $this->createForm(AddMemberCSVType::class);
        $form->handleRequest($request);

        // à la soumission du formulaire on recupere le fichier csv ...
        if($form->isSubmitted()){
            $file = $form->get('csvFile')->getData();
            $datas = file($file);

            // ... que l'on parcourir ligne par ligne
            foreach ($datas as $data){
                $array = explode(';', $data);
                $prenom = $array[0];
                $nom = $array[1];
                $motDePasse = $array[2];
                $email = $array[3];

                // On créer un utilisateur
                $user = new Participant();
                $user->setEmail($email);
                $user->setCampus($campusRepository->findAll()[0]);
                $user->setPseudo($nom . '.' . $prenom);
                $user->setIsActif(true);
                $encoded = $encoder->encodePassword($user, $motDePasse);
                $user->setPassword($encoded);
                $user->setRoles(['ROLE_USER']);
                $user->setNom($nom);
                $user->setPrenom($prenom);

                $entityManager->persist($user);
                $entityManager->flush();
            }
            return $this->redirectToRoute('main_home');
        }

        return $this->render('admin/index.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
