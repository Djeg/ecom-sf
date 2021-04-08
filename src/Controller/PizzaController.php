<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Pizza;
use App\Form\PizzaType;
use Twig\Environment;
use App\Repository\PizzaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PizzaController extends AbstractController
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

    /**
     * Créé une nouvelle pizza en utilisant le composant de formulaire
     * *
     * @Route("/pizzas/new", name="create_pizza", methods={"GET", "POST"})
     */
    public function createPizza(
        EntityManagerInterface $manager,
        FormFactoryInterface $formFactory,
        Environment $twig,
        Request $request
    ): Response {
        $pizza = new Pizza();

        $form = $formFactory->create(PizzaType::class, $pizza);
        $form->handleRequest($request);
        $isSuccess = false;

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $manager->persist($task);
            $manager->flush();

            $isSuccess = true;
        }

        $template = $twig->render('pizza/create.html.twig', [
            'form' => $form->createView(),
            'isSuccess' => $isSuccess,
            'pizza' => $pizza,
        ]);

        return new Response($template);
    }
}
