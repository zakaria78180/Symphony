<?php

namespace App\Controller;

use App\Entity\Album;
use App\Repository\AlbumRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class AlbumController extends AbstractController
{
    #[Route('/albums', name: 'app_albums' , methods:['GET'])]

    public function listealbums(AlbumRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        $albums = $paginator->paginate(
        $repo->listeAlbumsComplete(),
        $request->query->getInt('page',1),
        9
        );
        return $this->render('album/listeAlbum.html.twig', [
            'lesAlbums' => $albums
        ]);
    }

    #[Route('/album/{id}', name: 'fichealbum', methods: ['GET'])]
    public function fichealbum(Album $album)
    {
        return $this->render('album/ficheAlbum.html.twig', [
            'leAlbum' => $album
        ]);
    }
}
