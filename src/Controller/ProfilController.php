<?php

namespace App\Controller;

use App\Form\EditProfileType;
use App\Form\EditProfilType;
use App\Repository\ParticipantRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("/profil", name="profil_")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }

    /**
     * @Route("/modifier", name="modify")
     */
    public function modify(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'Profil mis a jour');
            return $this->redirectToRoute('profil_home');
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
                $this->addFlash('message','Mot de passe mis a jour avec succes');
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
}
