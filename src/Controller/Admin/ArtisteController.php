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

    public function modifArtiste(Request $request, EntityManagerInterface $manager)
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
    
    

}
