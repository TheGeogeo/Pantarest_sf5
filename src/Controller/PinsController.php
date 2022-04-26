<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Form\PinType;
use App\Repository\PinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: 'GET')]
    public function index(PinRepository $pinRepository): Response
    {
        $pins = $pinRepository->findBy([], ['createdAt' => 'DESC']);
        return $this->render('pins/index.html.twig', [
            'pins' => $pins
        ]);
    }

    #[Route('/pins/{id<[0-9]+>}', name: 'app_pin_show', methods: 'GET')]
    public function show(Pin $pin): Response
    {
        return $this->render('pins/show.html.twig', [
            'pin' => $pin
        ]);
    }

    #[Route('/pins/create', name: 'app_pin_create')]
    public function create(Request $request, PinRepository $pinRepository): Response
    {
        $form = $this->createForm(PinType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pin = $form->getData();
            $pinRepository->add($pin);
            return $this->redirectToRoute('app_home');
        }


        return $this->render('pins/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/pins/{id<[0-9]+>}/edit}', name: 'app_pin_edit', methods:['GET','PUT'])]
    public function update(Pin $pin, Request $request, PinRepository $pinRepository): Response
    {

        $form = $this->createForm(PinType::class, $pin, [
            'method' => 'PUT'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pin = $form->getData();
            $pinRepository->add($pin);
            return $this->redirectToRoute('app_pin_show', [
                'id' => $pin->getId()
            ]);
        }

        return $this->render('pins/update.html.twig', [
            'form' => $form->createView(),
            'pin' => $pin
        ]);
    }
}
