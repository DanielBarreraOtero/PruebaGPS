<?php

namespace App\Controller;

use App\Entity\Mensaje;
use App\Repository\BandaRepository;
use App\Repository\MensajeRepository;
use App\Repository\ModoRepository;
use App\Repository\ParticipanteRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_mensaje')]
class ApiMensajeController extends AbstractController
{
    #[Route('/mensaje/{id}', name: 'get_mensaje', methods: 'GET')]
    public function getMensaje(MensajeRepository $repoMensj, int $id): Response
    {
        $mensaje = $repoMensj->find($id);

        if ($mensaje === null) {
            return $this->json(['ok' => false, 'message' => 'no se ha podido encontrar el mensaje ' . $id], 404);
        }

        $mensajes[] = $mensaje;

        return $this->json(['ok' => true, 'mensajes' => $mensajes], 200);
    }

    #[Route('/mensaje/all/{indicativo}', name: 'get_mensajes', methods: 'GET')]
    public function getMensajes(MensajeRepository $repoMensj, string $indicativo): Response
    {

        $mensajes = $repoMensj->findForJuez($indicativo);

        if (!isset($mensajes[0])) {
            return $this->json(['ok' => false, 'message' => 'no se han encontrado mensajes'], 404);
        }

        return $this->json(['ok' => true, 'mensajes' => $mensajes], 200);
    }

    #[Route('/mensaje', name: 'post_mensaje', methods: 'POST')]
    public function postMensaje(Request $request, MensajeRepository $repoMensj, ParticipanteRepository $repoPart, BandaRepository $repoBand, ModoRepository $repoModo): Response
    {
        $mensaje = json_decode($request->request->get('mensaje'));

        $newMensaje = new Mensaje();
        $newMensaje->setBanda($repoBand->find($mensaje->banda_id));
        $newMensaje->setModo($repoModo->find($mensaje->modo_id));
        $newMensaje->setParticipante($repoPart->find($mensaje->participante_id));
        $newMensaje->setHora(new DateTime($mensaje->hora->date));
        $newMensaje->setValidado(false);
        $newMensaje->setIndicativoJuez($mensaje->indicativoJuez);

        $repoMensj->save($newMensaje, true);

        return $this->json(['ok' => true, 'mensaje' => $newMensaje], 201);
    }

    #[Route('/mensaje', name: 'put_mensaje', methods: 'PUT')]
    public function putMensaje(Request $request, MensajeRepository $repoMensj, ParticipanteRepository $repoPart, BandaRepository $repoBand, ModoRepository $repoModo): Response
    {
        $mensaje = json_decode($request->getContent())->mensaje;

        $newMensaje = $repoMensj->find($mensaje->id);
        $newMensaje->setBanda($repoBand->find($mensaje->banda_id));
        $newMensaje->setModo($repoModo->find($mensaje->modo_id));
        $newMensaje->setParticipante($repoPart->find($mensaje->participante_id));
        $newMensaje->setHora(new DateTime($mensaje->hora->date));
        $newMensaje->setValidado($mensaje->validado);
        $newMensaje->setIndicativoJuez($mensaje->indicativoJuez);

        $repoMensj->save($newMensaje, true);

        return $this->json(['ok' => true, 'mensaje' => $newMensaje], 200);
    }

    #[Route('/mensaje', name: 'delete_mensaje', methods: 'DELETE')]
    public function deleteMensaje(Request $request, MensajeRepository $repoMensj): Response
    {
        $mensaje = json_decode($request->getContent())->mensaje;

        $newMensaje = $repoMensj->find($mensaje->id);

        $repoMensj->remove($newMensaje, true);

        return $this->json(['ok' => true, 'mensaje' => $newMensaje], 200);
    }
}
