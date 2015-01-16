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
            "movie" => $movie,
        );
        
        return $this->render("movie/movie_details.html.twig", $params);
    }
    
    /**
     * @Route("/{page}", name="listMovies", requirements={"page"="\d+"}, defaults={"page"="1"})
     */
    public function listMoviesAction($page)
    {
        // recupére les films depuis la bdd
        $movieRepository = $this->getDoctrine()->getRepository("AppBundle:Movie");
        $numPerPage =50;
        $offset =($page -1)* $numPerPage;
        
        $moviesNumber =$movieRepository->countAll();
        $maxPages = ceil($moviesNumber / $numPerPage);
        
        // SI l'utilisateur a deconné avec l'url...
        // Page trop grande : on le redirige vers la dernière page
        if($page > $maxPages){
            return $this->redirect(
                    $this->generateUrl("listMovies", array("page" =>$maxPages) )
            );
        }
        //à l'invers, page trop petite :
        //si sur la page "" par exemple...
        elseIf($page<1){
            return $this->redirect(
                    $this->generateUrl("listMovies", array("page"=>1))
            );
        }
        $movies = $movieRepository->findBy(array(), array(
                        "year" => "DESC",
                        "title" => "ASC"
                        ), $numPerPage, $offset
        );
                
        //prepare l'envoi à la vue
        $params = array(
            "movies" => $movies,
            "currentPage" => $page,
            "moviesNumber" =>$moviesNumber,
            "maxPages" => $maxPages,
            "numPerPage"=>$numPerPage
        );
        
        

        return $this->render("movie/list_movies.html.twig", $params);
    }
}