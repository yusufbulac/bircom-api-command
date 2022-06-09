<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController{

    /**
     * @Route ("/", name="index")
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function movie(MovieRepository $movieRepository):Response{

        $movies = $movieRepository->findAll();

        return $this->render('movie/index.html.twig',[
            'movies' => $movies
        ]);
    }
}