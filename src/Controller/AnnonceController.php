<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    /**
     * @Route("/annonce")
     */

class AnnonceController extends AbstractController
{

    //Ajouter une annonce


    /**
     * @Route("/add", name="add_annonce")
     */

    public function Add(Request $request)
    {
        $annonce = new Annonce();

        $form=$this->createForm(AnnonceType::class,$annonce);

        $form->handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()) {
            
             $em = $this -> getDoctrine()->getManager();
             $em->persist($annonce);
             $em->flush();

             return $this->redirectToRoute("list_annonce");
        }

        return $this->render('annonce/formadd.html.twig', [
            'form' => $form->createView(),'btn'=>'Ajouter'
        ]);
    }

    //Modifier une annonce 

      /**
     * @Route("/edit/{id}", name="edit_annonce")
     */
    public function edit(Request $request, $id)
    {
        $annonce = $this->getDoctrine()->getRepository(Annonce::class)->find($id);

        $form=$this->createForm(AnnonceType::class,$annonce);

        $form->handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()) {
            
             $em = $this -> getDoctrine()->getManager();
             $em->persist($annonce);
             $em->flush();

             return $this->redirectToRoute("list_annonce");
        }

        return $this->render('annonce/formadd.html.twig', [
            'form' => $form->createView(),'btn'=>'Modifier'
        ]);
    }

    

        //lister tous les annonces

     /**
     * @Route("/list", name="list_annonce")
     */
    public function list()
    {
        $annonce= $this->getDoctrine()->getRepository(Annonce::class)->findAll();


        return $this->render('annonce/list.html.twig', [
            'annonces' => $annonce,
        ]);
    }

    //supprimer une annonce

    /**
     * @Route("/sup/{id}", name="sup_annonce")
     */
    public function delete($id)
    {


        $annonce= $this->getDoctrine()->getRepository(Annonce::class)->find($id);

        if(!$annonce) 
        {
            throw $this-> createNotFoundException(
                'Equipe id : '.$id.' est inexistant ..' 
            );
        }

        $em=$this->getDoctrine()->getManager();
        $em->remove($annonce);
        $em->flush();

        return $this->redirectToRoute('list_annonce');
    }

    //afficher detaile  d'une annonce
       
    /**
     * @Route("/show/{id}", name="show_annonce")
     */
    public function show($id)
    {

 
        $annonce= $this->getDoctrine()->getRepository(Annonce::class)->find($id);

        if(!$annonce) 
        {
            throw $this-> createNotFoundException(
                'Equipe id : '.$id.' est inexistant ..' 
            );
        }

        return $this ->render('annonce/show.html.twig',[
             'annonce'=> $annonce,
        ]);
    }




    /**
     * @Route("/annonce", name="annonce")
     */
    public function index()
    {
        return $this->render('annonce/index.html.twig', [
            'controller_name' => 'AnnonceController',
        ]);
    }
}
