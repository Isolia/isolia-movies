<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MovieController extends Controller
{
     /**
     * @Route("/movie/{id}", name="movieDetails")
     */
    public function movieDetailsAction($id)
    {
        $movieRepository = $this->getDoctrine()->getRepository("AppBundle:Movie");
        $movie = $movieRepository->find($id);

        $params = array(
            "movie" => $movie
        );
        
        return $this->render("movie/movie_details.html.twig", $params);
    }
    
    /**
     * @Route("/movie", name="listMovies")
     */
    public function listMoviesAction()
    {
        // recupére les films depuis la bdd
        $movieRepository = $this->getDoctrine()->getRepository("AppBundle:Movie");
        $movies = $movieRepository->findBy(array(), array(
                        "year" => "DESC",
                        "title" => "DESC"
                        ), 50, 0
        );
        
        $moviesNumber =$movieRepository->countAll();
        
        //prepare l'envoi à la vue
        $params = array(
            "movies" => $movies,
            "moviesNumber" =>$moviesNumber
        );

        return $this->render("movie/list_movies.html.twig", $params);
    }
}