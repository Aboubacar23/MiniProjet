<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Form\MembreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/membre")
    */
class MembreController extends AbstractController
{
    //Ajouter un membre


    /**
     * @Route("/add", name="add_membre")
     */
    public function Add(Request $request)
    {
        $membre = new Membre();

        $form=$this->createForm(MembreType::class,$membre);

        $form->handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()) {
            
             $em = $this -> getDoctrine()->getManager();
             $em->persist($membre);
             $em->flush();

             return $this->redirectToRoute("list_membre");
        }

        return $this->render('membre/formadd.html.twig', [
            'form' => $form->createView(),'btn'=>'Ajouter'
        ]);
    }

        //Modifier un membre 

      /**
     * @Route("/edit/{id}", name="edit_membre")
     */
    public function edit(Request $request, $id)
    {
        $membre = $this->getDoctrine()->getRepository(Membre::class)->find($id);

        $form=$this->createForm(MembreType::class,$membre);

        $form->handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()) {
            
             $em = $this -> getDoctrine()->getManager();
             $em->persist($membre);
             $em->flush();

             return $this->redirectToRoute("list_membre");
        }

        return $this->render('membre/formadd.html.twig', [
            'form' => $form->createView(),'btn'=>'Modifier'
        ]);
    }

        //lister tous  les membres

     /**
     * @Route("/list", name="list_membre")
     */
    public function list()
    {
        $membre= $this->getDoctrine()->getRepository(Membre::class)->findAll();


        return $this->render('membre/list.html.twig', [
            'membres' => $membre,
        ]);
    }


    //supprimer un membre
    /**
     * @Route("/sup/{id}", name="sup_membre")
     */
    public function delete($id)
    {


        $membre= $this->getDoctrine()->getRepository(Membre::class)->find($id);

        if(!$membre) 
        {
            throw $this-> createNotFoundException(
                'Equipe id : '.$id.' est inexistant ..' 
            );
        }

        $em=$this->getDoctrine()->getManager();
        $em->remove($membre);
        $em->flush();

        return $this->redirectToRoute('list_membre');
    }


       //afficher detaile  d'un membre
       
    /**
     * @Route("/show/{id}", name="show_membre")
     */
    public function show($id)
    {

 
        $membre= $this->getDoctrine()->getRepository(Membre::class)->find($id);

        if(!$membre) 
        {
            throw $this-> createNotFoundException(
                'Equipe id : '.$id.' est inexistant ..' 
            );
        }

        return $this ->render('membre/show.html.twig',[
             'membre'=> $membre,
        ]);
    }

     /**
     * @Route("/membre", name="membre")
     */
    public function index()
    {
        return $this->render('membre/index.html.twig', [
            'controller_name' => 'MembreController',
        ]);
    }
}
