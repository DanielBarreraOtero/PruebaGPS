<?php

namespace App\Controller;

use App\Entity\Participante;
use App\Form\MensajeFormType;
use App\Repository\MensajeRepository;
use App\Repository\ParticipanteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $usuario = $this->getUser();

        if ($usuario !== null) {
            if (in_array('ROLE_JUEZ', $usuario->getRoles())) {
                return $this->redirectToRoute('juez');
            }

            return $this->redirectToRoute('participante');
        }

        return $this->redirectToRoute('app_login');
    }

    #[Route('/participante', name: 'participante')]
    public function participante(Request $request, MensajeRepository $repoMensj, ParticipanteRepository $repoPart): Response
    {
        $form = $this->createForm(MensajeFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mensaje = $form->getData();

            $mensaje->setParticipante($repoPart->find($this->getUser()->getId()));
            $mensaje->setValidado(false);

            $repoMensj->save($mensaje, true);

            return $this->redirectToRoute('participante');
        }

        


        return $this->render('main/participante.html.twig', [
            "form" => $form,
            "mensajes" => $this->getUser()->getMensajesNotLazy()
        ]);
    }

    #[Route('/juez', name: 'juez')]
    public function juez(): Response
    {
        return $this->render('main/juez.html.twig');
    }
}
