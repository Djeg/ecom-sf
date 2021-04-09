<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Pizza;
use App\Form\DeletePizzaType;
use App\Form\PizzaType;
use Container2hpxX73\getManagerRegistryAwareConnectionProviderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PizzaController extends AbstractController
{
    /**
     * List l'intégralité des pizzas disponible
     * 
     * @Route("/pizzas", name="pizza_list", methods={"GET"})
     */
    public function list(): Response
    {
        $pizzas = $this
            ->getDoctrine()
            ->getRepository(Pizza::class)
            ->findAll();

        $data = [];

        foreach ($pizzas as $pizza) {
            $data[$pizza->getId()] = [
                'pizza' => $pizza,
                'deleteForm' => $this
                    ->createForm(DeletePizzaType::class, $pizza)
                    ->createView(),
            ];
        }

        return $this->render('pizza/list.html.twig', [
            'data' => $data,
        ]);
    }

    /**
     * Créé une nouvelle pizza en utilisant le composant de formulaire
     * *
     * @Route("/pizzas/new", name="pizza_create", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $pizza = new Pizza();

        $form = $this->createForm(PizzaType::class, $pizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $manager = $this->getDoctrine()->getManager();

            $manager->persist($task);
            $manager->flush();

            return $this->redirectToRoute('pizza_list');
        }

        return $this->render('pizza/create.html.twig', [
            'form' => $form->createView(),
            'pizza' => $pizza,
        ]);
    }

    /**
     * Met à jour une pizza
     * 
     * @Route("pizza/{id}/update", name="pizza_update", methods={"GET", "POST"})
     */
    public function update(Pizza $pizza, Request $request): Response
    {
        $form = $this->createForm(PizzaType::class, $pizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $manager = $this->getDoctrine()->getManager();

            $manager->persist($task);
            $manager->flush();

            return $this->redirectToRoute('pizza_list');
        }

        return $this->render('pizza/update.html.twig', [
            'form' => $form->createView(),
            'pizza' => $pizza,
        ]);
    }

    /**
     * Suprime une pizza
     * 
     * @Route("pizza/{id}/delete", name="pizza_delete", methods={"POST"})
     */
    public function delete(Pizza $pizza, Request $request): Response
    {
        $form = $this->createForm(DeletePizzaType::class, $pizza);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->redirectToRoute('pizza_list');
        }

        $manager = $this->getDoctrine()->getManager();

        $manager->remove($pizza);
        $manager->flush();

        return $this->redirectToRoute('pizza_list');
    }
}
