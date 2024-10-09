<?php

namespace App\Controller\Admin;

use App\Entity\Artiste;
use App\Form\ArtisteType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArtisteController extends AbstractController
{
    #[Route('/admin/artistes', name: 'app_admin_artistes' , methods:['GET'])]

    public function listeArtistes(ArtisteRepository $repo,PaginatorInterface $paginator,Request $request)
    {
        $artistes = $paginator->paginate(
                $repo->listeArtistesCompletePaginee(),
                $request->query->getInt('page',1),
                9
        );
        return $this->render('admin/artiste/listeArtiste.html.twig', [
            'lesArtistes' => $artistes
        ]);

    }

    #[Route('/admin/artiste/ajout', name: 'app_admin_artiste_ajout' , methods:['GET','POST'])]

    public function AjoutArtiste()
    {
        $artiste=new Artiste();
        $form=$this->createForm(ArtisteType::class,$artiste);
        return $this->render('admin/artiste/formAjoutArtiste.html.twig', [
            'formArtiste' => $form->createView()
        ]);

    }

}
