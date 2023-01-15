<?php

namespace App\Controller;
use App\Entity\Insurance;
use App\Form\InsuranceType;
use App\Service\MessageGenerator;
use App\Repository\UserRepository;
use App\Repository\InsuranceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InsuranceController extends AbstractController
{
    /**
     * @Route("/insurance", name="app_insurance")
     */
    public function index(): Response
    {
        return $this->render('insurance/index.html.twig', [
            'controller_name' => 'InsuranceController',
        ]);
    }

     /**
     * @Route("/insurance/add/{name}/{discount}", name="insurance_ajou")
     */
    public function add($name,$discount,ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $insurance = new Insurance();
        $insurance->setName($name);
        $insurance->setDiscount($discount);
        $entityManager->persist($insurance);
        $entityManager->flush();
        return $this->render('insurance/add.html.twig', ["insurance" => $insurance  ]);
    }
     /**
     * @Route("/insurance/list", name="app_insurance_list")
     */
    public function list(InsuranceRepository $repos): Response//,MessageGenerator $mg
    {
        //$user = $this->getUser();
       // dd($user);
        //$email = $user->getEmail();
       // $message = $mg->getHappyMessage();    ,"ema"=>$email,"msg" =>$message
        $insurances = $repos->findAll();
        return $this->render('insurance/list.html.twig', ["insurances"=>$insurances]);

    }
    /**
     * @Route("/insurance/del/{id}", name="app_insurance_delete")
     */
    public function delete($id,InsuranceRepository $repos,ManagerRegistry $doctrine): Response
    {
        $insurance=$repos->find($id);
        $entityManager = $doctrine->getManager();
        $entityManager->remove($insurance);
        $entityManager->flush();
        return $this->redirectToRoute('app_insurance_list');
        //return $this->render('insurance/add.html.twig', ["insurance" => $insurance  ]);
    }
     /**
     * @Route("/insurance/edit/{id}", name="app_insurance_edit")
     */


    public function edit(int $id , Request $request , InsuranceRepository $repos)
    {
       // $this->denyAccessUnlessGranted('ROLE_ADMIN');
         $insurance=$repos->find($id);
        $form = $this->createForm(InsuranceType::class,$insurance,[
                'method' => 'GET',
        ]);
       //traitement du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           // $form->getData() holds the submitted values
           // but, the original `$task` variable has also been updated
           $insurance = $form->getData();
           $em = $this->getDoctrine()->getManager();
           $em->persist($insurance);
           $em->flush();
           // ... perform some action, such as saving the task to the database

           return $this->redirectToRoute('app_insurance_list');
       }

       //return $this->render('/insurance/ajout.html.twig',['form' => $form->createView()]);
       return $this->renderForm('/insurance/add.html.twig',['form' => $form]);
    }
    

    /**
     * @Route("/insurance/detail/{id}", name="app_insurance_detail")
     */
    public function detail($id,InsuranceRepository $repos): Response
    {
        $insurance=$repos->find($id);
        if(!$insurance)
        {
            return $this->render('insurance/erreur.html.twig', ["msg" => "Aucun insurance avec id:$id"  ]);     
        }
        //return $this->redirectToRoute('app_insurance_list');
        return $this->render('insurance/detail.html.twig', ["insurance" => $insurance  ]);
    }
    /**
     * @Route("/insurance/add", name="app_insurance_add")
     */
    public function ajout(Request $request,UserRepository $userrepo): Response
    {
       // $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $insurance = new insurance();
        $form = $this->createForm(InsuranceType::class,$insurance,[
                'method' => 'GET',
        ]);
       //traitement du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           // $form->getData() holds the submitted values
           // but, the original `$task` variable has also been updated
          // $task = $form->getData();
           $em = $this->getDoctrine()->getManager();
           $em->persist($insurance);
           $em->flush();
           // ... perform some action, such as saving the task to the database

           return $this->redirectToRoute('app_insurance_list');
       }

       //return $this->render('/insurance/ajout.html.twig',['form' => $form->createView()]);
       return $this->renderForm('/insurance/add.html.twig',['form' => $form]);
    }
}

