<?php

namespace App\Controller;

use App\Entity\Etablissement;
use App\Form\EtablissementType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    /**
     * @Route("/etablissement")
     */

class EtablissementController extends AbstractController
{
    //Ajouter un etablissement


    /**
     * @Route("/add", name="add_etablissement")
     */
    public function Add(Request $request)
    {
        $etablissement = new Etablissement();

        $form=$this->createForm(EtablissementType::class,$etablissement);

        $form->handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()) {
            
             $em = $this -> getDoctrine()->getManager();
             $em->persist($etablissement);
             $em->flush();

             return $this->redirectToRoute("list_etablissement");
        }

        return $this->render('etablissement/form_add.html.twig', [
            'form' => $form->createView(),'btn'=>'Ajouter Etablissement'
        ]);
    }

        //Modifier un etablissement 

      /**
     * @Route("/edit/{id}", name="edit_etablissement")
     */
    public function edit(Request $request, $id)
    {
        $etablissement = $this->getDoctrine()->getRepository(Etablissement::class)->find($id);

        $form=$this->createForm(EtablissementType::class,$etablissement);

        $form->handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()) {
            
             $em = $this -> getDoctrine()->getManager();
             $em->persist($etablissement);
             $em->flush();

             return $this->redirectToRoute("list_etablissement");
        }

        return $this->render('etablissement/form_add.html.twig', [
            'form' => $form->createView(),'btn'=>'Modifier Etablissement'
        ]);
    }

        //lister tous les etablissements

     /**
     * @Route("/list", name="list_etablissement")
     */
    public function list()
    {
        $etablissement= $this->getDoctrine()->getRepository(Etablissement::class)->findAll();


        return $this->render('membre/list.html.twig', [
            'etablissements' => $etablissement,
        ]);
    }

    //supprimer une equipe

    /**
     * @Route("/sup/{id}", name="sup_etablissement")
     */
    public function delete($id)
    {


        $etablissement= $this->getDoctrine()->getRepository(Etablissement::class)->find($id);

        if(!$etablissement) 
        {
            throw $this-> createNotFoundException(
                'Equipe id : '.$id.' est inexistant ..' 
            );
        }

        $em=$this->getDoctrine()->getManager();
        $em->remove($etablissement);
        $em->flush();

        return $this->redirectToRoute('list_etablissement');
    }

    //afficher detaile  d'un etablissement
    /**
     * @Route("/show/{id}", name="show_etablissement")
     */
    public function show($id)
    {

 
        $etablissement= $this->getDoctrine()->getRepository(Etablissement::class)->find($id);

        if(!$etablissement) 
        {
            throw $this-> createNotFoundException(
                'Equipe id : '.$id.' est inexistant ..' 
            );
        }

        return $this ->render('etablissement/show.html.twig',[
             'etablissement'=> $etablissement,
        ]);
    }

    /**
     * @Route("/etablissement", name="etablissement")
     */
    public function index()
    {
        return $this->render('etablissement/index.html.twig', [
            'controller_name' => 'EtablissementController',
        ]);
    }
}
