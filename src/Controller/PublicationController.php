<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/publication")
 */
class PublicationController extends AbstractController
{
    /**
     * @Route("/", name="publication_index", methods={"GET"})
     */
    public function index(PublicationRepository $publicationRepository): Response
    {
        return $this->render('publication/index.html.twig', [
            'publications' => $publicationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="publication_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $sluggerInterface): Response
    {
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $document = $form->get('Document')-> getData();

            if($document){

                $originalFile = pathinfo($document->getClientOriginalName(),PATHINFO_FILENAME);
                $filename = $originalFile;
                $newFilename = $filename. '.'.uniqid().'.'.$document->guessExtension();

                try {
                    $document ->move(
                        $this-> getParameter('brochures_directory'),
                        $newFilename
                    );

                } catch (FileException $e) {
                    //throw $th;
                }
                $publication->setDocument($newFilename);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($publication);
            $entityManager->flush();

            return $this->redirectToRoute('publication_index');
        }

        
    }
    return $this->render('publication/new.html.twig', [
        'publication' => $publication,
        'form' => $form->createView(),
    ]);
}

    /**
     * @Route("/{id}", name="publication_show", methods={"GET"})
     */
    public function show(Publication $publication): Response
    {
        return $this->render('publication/show.html.twig', [
            'publication' => $publication,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="publication_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Publication $publication): Response
    {
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publication_index');
        }

        return $this->render('publication/edit.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="publication_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Publication $publication): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publication->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($publication);
            $entityManager->flush();
        }

        return $this->redirectToRoute('publication_index');
    }
}
