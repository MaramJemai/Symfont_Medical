<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register/{play}", name="app_register")
     */
    public function register($play ,Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPlay($play);
        if($play=='patient')
        {
            $user->setRoles(['ROLE_PATIENT']);}
        
        else if($play=='doctor')
            {
                $user->setRoles(['ROLE_DOCTOR']);
            }
               
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_login');
        }

        else {
        if($play=='doctor')

       { return $this->render('registration/registerd.html.twig', [
            'registrationForm' => $form->createView(),
        ]);}


        else if($play=='patient')
        {
           
            $form->remove('speciality');
            $form->remove('governorate');
            $form->remove('consult_fees');
            $form->remove('insurance.label');

        
            return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);}}
        
    }





}
