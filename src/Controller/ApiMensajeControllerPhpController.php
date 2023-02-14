<?php

namespace App\Controller;

use App\Repository\BandaRepository;
use App\Repository\MensajeRepository;
use App\Repository\ModoRepository;
use App\Repository\ParticipanteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_mensaje')]
class ApiMensajeControllerPhpController extends AbstractController
{
    #[Route('/mensaje/{id}', name: 'get_mensaje', methods:'GET')]
    public function getMensaje(MensajeRepository $repoMensj, int $id = null): Response
    {
        if ($id !== null) {
            $mensaje = $repoMensj->find($id);

            if ($mensaje === null) {
                return $this->json(['ok'=> false, 'message' => 'no se ha podido encontrar el mensaje '.$id], 404);        
            }

            $mensajes[] = $mensaje;
        } else {
            $mensajes = $repoMensj->findAll();

            if (!isset($mensajes[0])) {
                return $this->json(['ok'=> false, 'message' => 'no se han encontrado mensajes'], 404);
            }
        }


        return $this->json(['ok'=> true, 'mensajes' => $mensajes], 200);
    }
    
    #[Route('/mensaje', name: 'post_mensaje', methods:'POST')]
    public function postMensaje(Request $request, MensajeRepository $repoMensj, ParticipanteRepository $repoPart, BandaRepository $repoBand, ModoRepository $repoModo): Response
    {
        $mensaje = json_decode($request->request->get('mensaje'));




        return $this->json(['ok'=> true, 'mensaje' => $mensaje->si], 200);
    }
}
