<?php

namespace App\Controller;

use App\Repository\SortieRepository;
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

        return $this->render('main/index.html.twig', [
            "sorties" => $sorties
        ]);
    }
}
