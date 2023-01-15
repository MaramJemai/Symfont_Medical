<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Form\AppointmentType;
use App\Repository\UserRepository;
use App\Repository\AppointmentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppointmentController extends AbstractController
{
    /**
     * @Route("/appointment", name="app_appointment")
     */
    public function index(): Response
    {
        return $this->render('appointment/index.html.twig', [
            'controller_name' => 'AppointmentController',
        ]);
    }
  /**
     * @Route("/appointment/doctor/list", name="app_appointment_doctor_list")
     */
    public function listd(AppointmentRepository $repos): Response//,MessageGenerator $mg
    {
        $user = $this->getUser();
       // dd($user);
        //$email = $user->getEmail();
       // $message = $mg->getHappyMessage();    ,"ema"=>$email,"msg" =>$message

        $appointments = $repos->findBy1($user);
        $appointments1 = $repos->findBy2($user);

        return $this->render('appointment/listd.html.twig', ["appointments"=>$appointments , "appointments1"=>$appointments1]);

    }
      /**
     * @Route("/appointment/patient/list", name="app_appointment_patient_list")
     */
    public function listp(AppointmentRepository $repos): Response//,MessageGenerator $mg
    {
        $user = $this->getUser();
       // dd($user);
        //$email = $user->getEmail();
       // $message = $mg->getHappyMessage();    ,"ema"=>$email,"msg" =>$message

        $appointments = $repos->findBy3($user);
        $appointments1 = $repos->findBy4($user);

        return $this->render('appointment/listp.html.twig', ["appointments"=>$appointments , "appointments1"=>$appointments1 ]);

    }
      /**
     * @Route("/appointment/book/{idd}", name="app_appointment_book")
     */
    public function ajout($idd ,Request $request,UserRepository $userrepo , AppointmentRepository $apprepos): Response
    {
       // $this->denyAccessUnlessGranted('ROLE_PATIENT');

        $appointment = new Appointment();
        $form = $this->createForm( AppointmentType::class,$appointment,[
                'method' => 'GET',
        ]);
       //traitement du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           // $form->getData() holds the submitted values
           // but, the original `$task` variable has also been updated
          // $task = $form->getData();
          $appointment->setDoctor($userrepo->find($idd));
          $appointment->setPatient($this->getUser());
          $appointment->setState('pending');
           $em = $this->getDoctrine()->getManager();
           $em->persist($appointment);
           $em->flush();
           // ... perform some action, such as saving the task to the database

           return $this->redirectToRoute('app_appointment_patient_list');
       }
       //return $this->render('/insurance/ajout.html.twig',['form' => $form->createView()]);
       return $this->renderForm('/appointment/booking.html.twig',['form' => $form]);
    }



    /**
     * @Route("/appointment/del/{id}", name="app_appointment_delete")
     */
    public function delete($id,AppointmentRepository $repos,ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        $appointment=$repos->find($id);
        $entityManager = $doctrine->getManager();
        $entityManager->remove($appointment);
        $entityManager->flush();
        if($user->getPlay()=='patient')
        {
            return $this->redirectToRoute('app_appointment_patient_list');

        }
        else if($user->getPlay()=='doctor')
        {
            return $this->redirectToRoute('app_appointment_doctor_list');

        }
    }

    /**
     * @Route("/appointment/accept/{id}", name="app_appointment_accept")
     */
    public function accept($id,AppointmentRepository $repos,ManagerRegistry $doctrine): Response
    {
        $appointment=$repos->find($id);
        $appointment->setState('accepted');
        $em = $this->getDoctrine()->getManager();
        $em->persist($appointment);
        $em->flush();
        return $this->redirectToRoute('app_appointment_doctor_list');
    }

}
