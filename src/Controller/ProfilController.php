<?php

namespace App\Controller;

use App\Form\EditProfileType;
use App\Form\EditProfilType;
use App\Repository\ParticipantRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;


/**
 * @Route("/profil", name="profil_")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/modifier", name="modify")
     */
    public function modify(Request $request, ParticipantRepository $participantRepository, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        $user = $participantRepository->findOneBy(["email" => $this->getUser()->getUsername()]);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('photoProfil')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('miniature_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setPhotoProfil($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Profil mis à jour');
            return $this->redirectToRoute('profil_home', ['id' => $user->getId()]);
        }
        return $this->render('profil/modify.html.twig',[
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/modifyPassword", name="modifyPassword")
     */
    public function modifyPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if($request->isMethod("POST")){
            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();

            //Verify if 2 passwords are the same
            if($request->request->get('pass') == $request->request->get('passConf')){
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('pass')));
                $em->flush();
                $this->addFlash('success','Mot de passe mis a jour avec succes');
                return $this->redirectToRoute('profil_home');
            }else{
                $this->addFlash('message', "Les deux mots de passe ne sont pas identiques");
            }
        }
        return $this->render('profil/modifyPassword.html.twig');
    }


    /**
     * @Route("/supprimer/{id}", name="delete")
     */
    public function delete($id, ParticipantRepository $participantRepository ):RedirectResponse
    {
        $user = $participantRepository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $this->addFlash('success','Votre compte à bien été supprimé');
        return $this->redirectToRoute('main_home');
    }

    /**
     * @Route("/", name="home")
     * @Route("/{id}", name="home")
     */
    public function index($id, ParticipantRepository $participantRepository): Response
    {
        $user = $participantRepository->find($id);
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'user' => $user
        ]);
    }
}
