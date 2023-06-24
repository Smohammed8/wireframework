<?php

namespace App\Controller;

use App\Entity\Stream;
use App\Form\StreamType;
use App\Repository\StreamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/stream')]
class StreamController extends AbstractController
{
    #[Route('/', name: 'app_stream_index', methods: ['GET'])]
    public function index(StreamRepository $streamRepository): Response
    {
        return $this->render('stream/index.html.twig', [
            'streams' => $streamRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_stream_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StreamRepository $streamRepository): Response
    {
        $stream = new Stream();
        $form = $this->createForm(StreamType::class, $stream);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $streamRepository->save($stream, true);

            return $this->redirectToRoute('app_stream_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stream/new.html.twig', [
            'stream' => $stream,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stream_show', methods: ['GET'])]
    public function show(Stream $stream): Response
    {
        return $this->render('stream/show.html.twig', [
            'stream' => $stream,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stream_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Stream $stream, StreamRepository $streamRepository): Response
    {
        $form = $this->createForm(StreamType::class, $stream);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $streamRepository->save($stream, true);

            return $this->redirectToRoute('app_stream_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stream/edit.html.twig', [
            'stream' => $stream,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stream_delete', methods: ['POST'])]
    public function delete(Request $request, Stream $stream, StreamRepository $streamRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stream->getId(), $request->request->get('_token'))) {
            $streamRepository->remove($stream, true);
        }

        return $this->redirectToRoute('app_stream_index', [], Response::HTTP_SEE_OTHER);
    }
}
