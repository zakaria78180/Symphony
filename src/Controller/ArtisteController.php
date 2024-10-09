<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Form\ArtisteType;
use App\Repository\ArtisteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArtisteController extends AbstractController
{
    #[Route('/artistes', name: 'app_artistes' , methods:['GET'])]

    public function listeArtistes(ArtisteRepository $repo)
    {
        $artistes = $repo->listeArtistesComplete();
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
    #[Route('admin/artiste/ajout', name:'admin_artiste_ajout', methods:['GET','POST'])]

    public function ajoutModifArtiste(Artiste $artiste=null,Request $request, EntityManagerInterface $manager)
    {
        if($artiste==null){
             $artiste=new Artiste();
             $mode="ajouté";
        }else{
            $mode="modifié";

        }
       
        $form=$this->createForm(ArtisteType::class, $artiste);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
        
            $manager->persist($artiste);
            $manager->flush();
            $this->addFlash("success", "L'artiste a bien été ajouté");
            return $this->redirectToRoute('admin_artistes');
        }
        return $this->render('admin/artiste/formAjoutModifArtiste.html.twig', [
            'formArtiste' => $form->createView()
        ]);
    }
    #[Route('admin/artiste/modif/{id}', name:'admin_artiste_modif', methods:['GET','POST'])]
    public function modifArtiste(Artiste $artiste,Request $request, EntityManagerInterface $manager)
    {
        $form=$this->createForm(ArtisteType::class, $artiste);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
          
            $manager->persist($artiste);
            $manager->flush();
            $this->addFlash("success", "L'artiste a bien été modifié");
            return $this->redirectToRoute('admin_artistes');
        }
        return $this->render('admin/artiste/formModifArtiste.html.twig', [
            'formArtiste' => $form->createView()
            
        ]);
    }
}
