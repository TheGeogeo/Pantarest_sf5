<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Form\PinType;
use App\Repository\PinRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(PinRepository $pinRepository): Response
    {
        $pins = $pinRepository->findBy([], ['updatedAt' => 'DESC']);
        return $this->render('pin/index.html.twig', [
            'pins' => $pins,
        ]);
    }

    #[Route('/pins/new', name: 'app_pin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PinRepository $pinRepository, UserRepository $userRepo): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('error','You are not logged!');
            return $this->redirectToRoute("app_home");
        }

        $pin = new Pin();
        $form = $this->createForm(PinType::class, $pin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pinRepository->add($pin);

            $this->addFlash('success', 'Pin successfully created!');

            return $this->redirectToRoute('app_pin_show', ['id' => $pin->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pin/new.html.twig', [
            'pin' => $pin,
            'form' => $form,
        ]);
    }

    #[Route('/pins/{id}', name: 'app_pin_show', methods: ['GET'])]
    public function show(Pin $pin): Response
    {
        return $this->render('pin/show.html.twig', [
            'pin' => $pin,
        ]);
    }

    #[Route('/pins/{id}/edit', name: 'app_pin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pin $pin, PinRepository $pinRepository): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('error','You are not logged!');
            return $this->redirectToRoute("app_home");
        }

        $form = $this->createForm(PinType::class, $pin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pinRepository->add($pin);

            $this->addFlash('success', 'Pin successfully updated!');

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pin/edit.html.twig', [
            'pin' => $pin,
            'form' => $form,
        ]);
    }

    #[Route('/pins/{id}', name: 'app_pin_delete', methods: ['POST'])]
    public function delete(Request $request, Pin $pin, PinRepository $pinRepository): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('error','You are not logged!');
            return $this->redirectToRoute("app_home");
        }

        if ($this->isCsrfTokenValid('delete' . $pin->getId(), $request->request->get('_token'))) {
            $pinRepository->remove($pin);

            $this->addFlash('info', 'Pin successfully deleted!');
        }

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
