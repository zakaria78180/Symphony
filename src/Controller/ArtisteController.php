<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Repository\ArtisteRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArtisteController extends AbstractController
{
    #[Route('/artistes', name: 'app_artistes' , methods:['GET'])]

    public function listeArtistes(ArtisteRepository $repo)
    {
        $artistes = $repo->findAll();
        return $this->render('artiste/listeArtiste.html.twig', [
            'lesArtistes' => $artistes
        ]);
    }

    #[Route('/artistes/{id}', name: 'ficheArtistes', methods: ['GET'])]
    public function ficheArtiste(Artiste $artiste)
    {
        return $this->render('artiste/ficheArtiste.html.twig', [
            'leArtiste' => $artiste
        ]);
    }
}
