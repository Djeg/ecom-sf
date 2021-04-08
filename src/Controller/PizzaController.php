<?php

namespace App\Controller;

use App\Repository\PizzaRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class PizzaController
{
    /**
     * List l'intégralité des pizzas disponible
     * 
     * @Route("/pizzas", name="list_pizzas", methods={"GET"})
     */
    public function listPizzas(PizzaRepository $repository, Environment $twig): Response
    {
        $pizzas = $repository->findAll();

        $template = $twig->render('pizza/list.html.twig', [
            'pizzas' => $pizzas,
        ]);

        return new Response($template);
    }
}
