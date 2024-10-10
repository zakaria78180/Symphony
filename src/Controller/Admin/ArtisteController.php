<?php

namespace App\Controller\Admin;

use App\Entity\Artiste;
use App\Form\ArtisteType;
use App\Repository\ArtisteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArtisteController extends AbstractController
{
    #[Route('/admin/artistes', name: 'admin_artistes', methods: 'GET')]
    public function listeArtistes(ArtisteRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $artistes = $paginator->paginate(
            $repo->listeArtistesCompletePaginee(),
            $request->query->getInt('page', 1), // page number
            8 // limit per page
        );

        return $this->render('admin/artiste/listeArtistes.html.twig', [
            'lesArtistes' => $artistes,
        ]);
    }

    #[Route('/admin/artiste/ajout', name: 'admin_artiste_ajout', methods: ['GET', 'POST'])]
    #[Route('/admin/artiste/modif/{id}', name: 'admin_artiste_modif', methods: ['GET', 'POST'])]
    public function AjoutermodifArtiste(?Artiste $artiste, Request $request, EntityManagerInterface $manager): Response
    {
        if ($artiste == null) {
            $artiste = new Artiste();
            $mode = "ajouté";
        } else {
            $mode = "modifier";
        }

        $form = $this->createForm(ArtisteType::class, $artiste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $manager->persist($artiste);
            $manager->flush();
            $this->addFlash("success", "L'artiste a bien été ajouté");
            return $this->redirectToRoute('admin_artistes');
        }

        return $this->render('admin/artiste/formAjoutModifArtiste.html.twig', [
            'formArtiste' => $form->createView(),
        ]);
    }


    #[Route('/admin/artiste/suppression/{id}', name: 'admin_artiste_suppression', methods: ['GET'])]
    public function suppressionArtiste(Artiste $artiste, EntityManagerInterface $manager)
    {
            $nbAlbums=$artiste->getAlbums()->count();
            if($nbAlbums>0){
                $this->addFlash("danger", "vous ne pouvez pas supprimé cet artiste car $nbAlbums album(s) y sont associés");
            
            }else{
                 $manager->remove($artiste);
            $manager->flush();
          
            $this->addFlash("success", "L'artiste a bien été supprimé");

        }
            return $this->redirectToRoute('admin_artistes');
    }
    
    

}
