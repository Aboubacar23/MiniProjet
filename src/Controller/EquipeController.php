<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Form\EquipeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

       /**
     * @Route("/equipe")
     */

class EquipeController extends AbstractController
{
    //Ajouter une equipe


    /**
     * @Route("/add", name="add_equipe")
     */
    public function Add(Request $request)
    {
        $equipe = new Equipe();

        $form=$this->createForm(EquipeType::class,$equipe);

        $form->handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()) {
            
             $em = $this -> getDoctrine()->getManager();
             $em->persist($equipe);
             $em->flush();

             return $this->redirectToRoute("list_equipe");
        }

        return $this->render('equipe/formadd.html.twig', [
            'form' => $form->createView(),'btn'=>'Ajouter'
        ]);
    }

        //Modifier une equipe 

      /**
     * @Route("/edit/{id}", name="edit_equipe")
     */
    public function edit(Request $request, $id)
    {
        $equipe = $this->getDoctrine()->getRepository(Equipe::class)->find($id);

        $form=$this->createForm(EquipeType::class,$equipe);

        $form->handleRequest($request);

        if ($form -> isSubmitted() && $form -> isValid()) {
            
             $em = $this -> getDoctrine()->getManager();
             $em->persist($equipe);
             $em->flush();

             return $this->redirectToRoute("list_equipe");
        }

        return $this->render('equipe/formadd.html.twig', [
            'form' => $form->createView(),'btn'=>'Modifier'
        ]);
    }

        //lister toutes les equipes

     /**
     * @Route("/list", name="list_equipe")
     */
    public function list()
    {
        $equipe= $this->getDoctrine()->getRepository(Equipe::class)->findAll();


        return $this->render('equipe/list.html.twig', [
            'equipes' => $equipe,
        ]);
    }

    //supprimer une equipe
    /**
     * @Route("/sup/{id}", name="sup_equipe")
     */
    public function delete($id)
    {


        $equipe= $this->getDoctrine()->getRepository(Equipe::class)->find($id);

        if(!$equipe) 
        {
            throw $this-> createNotFoundException(
                'Equipe id : '.$id.' est inexistant ..' 
            );
        }

        $em=$this->getDoctrine()->getManager();
        $em->remove($equipe);
        $em->flush();

        return $this->redirectToRoute('list_equipe');
    }

    //afficher detaile  d'un membre
       
    /**
     * @Route("/show/{id}", name="show_equipe")
     */
    public function show($id)
    {

 
        $equipe= $this->getDoctrine()->getRepository(Equipe::class)->find($id);

        if(!$equipe) 
        {
            throw $this-> createNotFoundException(
                'Equipe id : '.$id.' est inexistant ..' 
            );
        }

        return $this ->render('equipe/show.html.twig',[
             'equipe'=> $equipe,
        ]);
    }


    /**
     * @Route("/equipe", name="equipe")
     */

    public function index()
    {
        return $this->render('equipe/index.html.twig', [
            'controller_name' => 'EquipeController',
        ]);
    }
}
