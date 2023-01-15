<?php

namespace App\Controller;

use App\Entity\Speciality;
use App\Form\SpecialityType;
use App\Repository\UserRepository;
use App\Repository\SpecialityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 /**
     * @Route("/{_locale}")
     */
class SpecialityController extends AbstractController
{
    /**
     * @Route("/speciality", name="app_speciality")
     */
    public function index(): Response
    {
        return $this->render('speciality/index.html.twig', [
            'controller_name' => 'SpecialityController',
        ]);
    }

    /**
     * @Route("/speciality/add/{name}", name="speciality_ajout")
     */
    public function add($name , ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $speciality = new Speciality();
        $speciality->setName($name);
        $entityManager->persist($speciality);
        $entityManager->flush();
        return $this->render('speciality/add.html.twig', ["speciality" => $speciality  ]);
    }
     /**
     * @Route("/speciality/list", name="app_speciality_list")
     */
    public function list(SpecialityRepository $repos): Response//,MessageGenerator $mg
    {
        //$user = $this->getUser();
       // dd($user);
        //$email = $user->getEmail();
       // $message = $mg->getHappyMessage();    ,"ema"=>$email,"msg" =>$message
        $specialities = $repos->findAll();
        return $this->render('speciality/list.html.twig', ["specialities"=>$specialities]);
    }
    /**
     * @Route("/speciality/del/{id}", name="app_speciality_delete")
     */
    public function delete($id,specialityRepository $repos,ManagerRegistry $doctrine): Response
    {
        $speciality=$repos->find($id);
        $entityManager = $doctrine->getManager();
        $entityManager->remove($speciality);
        $entityManager->flush();
        return $this->redirectToRoute('app_speciality_list');
        //return $this->render('speciality/add.html.twig', ["speciality" => $speciality  ]);
    }
     /**
     * @Route("/speciality/edit/{id}", name="app_speciality_edit")
     */


    public function edit(int $id , Request $request , specialityRepository $repos)
    {
       // $this->denyAccessUnlessGranted('ROLE_ADMIN');
         $speciality=$repos->find($id);
        $form = $this->createForm(specialityType::class,$speciality,[
                'method' => 'GET',
        ]);
       //traitement du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           // $form->getData() holds the submitted values
           // but, the original `$task` variable has also been updated
           $speciality = $form->getData();
           $em = $this->getDoctrine()->getManager();
           $em->persist($speciality);
           $em->flush();
           // ... perform some action, such as saving the task to the database

           return $this->redirectToRoute('app_speciality_list');
       }

       //return $this->render('/speciality/ajout.html.twig',['form' => $form->createView()]);
       return $this->renderForm('/speciality/add.html.twig',['form' => $form]);
    }
    

    /**
     * @Route("/speciality/detail/{id}", name="app_speciality_detail")
     */
    public function detail($id,specialityRepository $repos): Response
    {
        $speciality=$repos->find($id);
        if(!$speciality)
        {
            return $this->render('speciality/erreur.html.twig', ["msg" => "Aucun speciality avec id:$id"  ]);     
        }
        //return $this->redirectToRoute('app_speciality_list');
        return $this->render('speciality/detail.html.twig', ["speciality" => $speciality  ]);
    }
    /**
     * @Route("/speciality/add", name="app_speciality_add")
     */
    public function addit(Request $request,UserRepository $userrepo): Response
    {
       // $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $speciality = new Speciality();
        $form = $this->createForm(SpecialityType::class,$speciality,[
                'method' => 'GET',
        ]);
       //traitement du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           // $form->getData() holds the submitted values
           // but, the original `$task` variable has also been updated
          // $task = $form->getData();
           $em = $this->getDoctrine()->getManager();
           $em->persist($speciality);
           $em->flush();
           // ... perform some action, such as saving the task to the database

           return $this->redirectToRoute('app_speciality_list');
       }

       //return $this->render('/speciality/ajout.html.twig',['form' => $form->createView()]);
       return $this->renderForm('/speciality/add.html.twig',['form' => $form]);
    }
}
