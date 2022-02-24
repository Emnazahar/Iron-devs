<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Entity\Vol;
use App\Form\BilletType;
use App\Form\VolType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BilletController extends AbstractController
{
    /**
     * @Route("/billet", name="billet")
     */
    public function index(): Response
    {
        return $this->render('billet/index.html.twig', [
            'controller_name' => 'BilletController',
        ]);
    }

    /**
     * @Route ("listeB",name="listeB")
     */
    public function liste()
    {
        $billet = $this->getDoctrine()->getRepository(Billet::class)->findAll();
        return $this->render('billet/liste.html.twig',
            array('billet' => $billet));

    }

    /**
     * @Route("/removebillet/{id}",name="removebillet")
     */
    public function delete($id)
    {
        $billet = $this->getDoctrine()->getRepository(Billet::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($billet);
        $em->flush();
        return $this->redirectToRoute("listeB");
    }
    /**
     * @Route("/addB",name="addBillet")
     */
    public function add(Request$request )
    {
        $billet= new Billet();
        $form= $this->createForm(BilletType::class,$billet);
        $form->handleRequest($request);
        if($form->isSubmitted() ){
            $em = $this->getDoctrine()->getManager();
            $em->persist($billet);
            $em->flush();
            return $this->redirectToRoute("listeB");
        }
        return $this->render("billet/add.html.twig",array("form"=>$form->createView()));
    }
    /**
     * @Route("/updatebillet/{id}",name="updatebillet")
     */
    public function update(Request $request,$id){
        $billet= $this->getDoctrine()->getRepository(Billet::class)->find($id);
        $form= $this->createForm(BilletType::class,$billet);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("listeB");
        }
        return $this->render("billet/update.html.twig",array("form"=>$form->createView()));
    }



}
