<?php

namespace App\Controller;

use App\Repository\PizzaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PizzaController extends AbstractController
{
    /**
     * List l'intégralité des pizzas disponible
     * 
     * @Route("/pizzas", name="list_pizzas", methods={"GET"})
     */
    public function listPizzas(PizzaRepository $repository): Response
    {
        $pizzas = $repository->findAll();

        return $this->render('pizza/list.html.twig', [
            'pizzas' => $pizzas,
        ]);
    }
}
