<?php

namespace App\Controller;

use App\Entity\Statut;
use App\Form\StatutType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

     /**
     * @Route("/statut")
     */

class StatutController extends AbstractController
{

     //Ajouter un statut


    /**
     * @Route("/add", name="add_statut")
     */
    public function Add(Request $request)
    {
        $statut = new Statut();

        $form=$this->createForm(StatutType::class,$statut);

        $form->handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()) {
            
             $em = $this -> getDoctrine()->getManager();
             $em->persist($statut);
             $em->flush();

             return $this->redirectToRoute("list_statut");
        }

        return $this->render('statut/formadd.html.twig', [
            'form' => $form->createView(),'btn'=>'Ajouter'
        ]);
    }

        //Modifier un statut 

      /**
     * @Route("/edit/{id}", name="edit_statut")
     */
    public function edit(Request $request, $id)
    {
        $statut = $this->getDoctrine()->getRepository(Statut::class)->find($id);

        $form=$this->createForm(StatutType::class,$statut);

        $form->handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()) {
            
             $em = $this -> getDoctrine()->getManager();
             $em->persist($statut);
             $em->flush();

             return $this->redirectToRoute("list_statut");
        }

        return $this->render('statut/formadd.html.twig', [
            'form' => $form->createView(),'btn'=>'Modifier'
        ]);
    }

        //lister tous les statuts

     /**
     * @Route("/list", name="list_statut")
     */
    public function list()
    {
        $statut= $this->getDoctrine()->getRepository(Statut::class)->findAll();


        return $this->render('statut/list.html.twig', [
            'statuts' => $statut,
        ]);
    }

    //supprimer une equipe

    /**
     * @Route("/sup/{id}", name="sup_statut")
     */
    public function delete($id)
    {


        $statut= $this->getDoctrine()->getRepository(Statut::class)->find($id);

        if(!$statut) 
        {
            throw $this-> createNotFoundException(
                'Equipe id : '.$id.' est inexistant ..' 
            );
        }

        $em=$this->getDoctrine()->getManager();
        $em->remove($statut);
        $em->flush();

        return $this->redirectToRoute('list_statut');
    }


       //afficher detaile  d'un statut
       
    /**
     * @Route("/show/{id}", name="show_statut")
     */
    public function show($id)
    {

 
        $statut= $this->getDoctrine()->getRepository(Statut::class)->find($id);

        if(!$statut) 
        {
            throw $this-> createNotFoundException(
                'Equipe id : '.$id.' est inexistant ..' 
            );
        }

        return $this ->render('statut/show.html.twig',[
             'statut'=> $statut,
        ]);
    }


    /**
     * @Route("/statut", name="statut")
     */
    public function index()
    {
        return $this->render('statut/index.html.twig', [
            'controller_name' => 'StatutController',
        ]);
    }
}
