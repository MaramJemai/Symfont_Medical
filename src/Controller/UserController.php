<?php
namespace App\Controller;
use App\Entity\User;
use App\Form\ResearchType;
use App\Service\MessageGenerate;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="app_user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
     /**
     * @Route("/admin/db", name="admin_db")
     */
    public function adb(): Response
    {
        $user=$this->getUser();
        $email = $user->getEmail();
        return $this->render('user/admin_db.html.twig');
    }
     /**
     * @Route("/user/welcome", name="user_welcome")
     */
    public function welcome(MessageGenerate $msg): Response
    {
        $user=$this->getUser();
        $name= $user->getFirstName();
        $message11=$msg->getHappyMessage();
        $message12=$msg->getHappyMessage();

        $message21=$msg->getHappyMessage2();
        $message22=$msg->getHappyMessage2();

        if($user->getPlay() == 'doctor')
        {
            return $this->render('user/welcome.html.twig', ["name"=>$name , 'msg1'=>$message11, 'msg2'=>$message12]);
        }
        else 
        {
            return $this->render('user/welcome1.html.twig', ["name"=>$name , 'msg3'=>$message21 ,  'msg4'=>$message22]);
        }
    }
     /**
     * @Route("/user/profile", name="user_profile")
     */
    public function profil(UserRepository $repos): Response
    {
        $user=$this->getUser();  
        $idd=$user->getId();  
        $user=$repos->find($idd);
        $speciality=$user->getSpeciality();
        $insurance=$user->getInsurance();
        return $this->render('user/profil.html.twig', ["user"=>$user , "speciality"=>$speciality , "insurance"=>$insurance]); 
    }
     /**
     * @Route("/patient/db", name="patient_db")
     */
    public function pdb(Request $request,UserRepository $userrepo): Response
    {
        $user=$this->getUser();
        $user1 = new User();
        $form = $this->createForm(ResearchType::class ,$user1,[
        'method' => 'GET',
       ]);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
          $task = $form->getData();
         $doctors = $userrepo->findByExampleField($form['governorate']->getData(),$form['speciality']->getData(), $form['insurance']->getData() , $form['consult_fees']->getData());
         return $this->render('user/list.html.twig', ["doctors"=>$doctors]);
       }
        $email = $user->getEmail();
        return $this->render('user/patient_db.html.twig', [
            'controller_name' => 'UserController'
            ,"ema"=>$email ,
          'form'=>$form->createView(),
        ]);
    }
    /**
     * @Route("/user/detail/{idd}", name="app_user_detail")
     */
    public function detail($idd , UserRepository $repos): Response
    {
        $user1=$this->getUser();
        $user=$repos->find($idd);
        $speciality=$user->getSpeciality();
        $insurance=$user->getInsurance();
        if(!$user)
        {
            return $this->render('user/erreur.html.twig', ["msg" => "Aucun user avec id:$idd"  ]);     
        }
        return $this->render('user/detail.html.twig', ["user" => $user   , "speciality"=>$speciality , "insurance"=>$insurance]);
    }
}