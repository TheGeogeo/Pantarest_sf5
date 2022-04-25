<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PinRepository $pinRepository): Response
    { 
        return $this->render('pins/index.html.twig',[
            'pins' => $pinRepository->findAll()
        ]);
    }

    #[Route('/pins/{id<[0-9]+>}', name: 'app_pin_show')]
    public function show(Pin $pin): Response
    {
        return $this->render('pins/show.html.twig',[
            'pin' => $pin
        ]);
    }
}