<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Token;
use App\Services\sendMail;
use App\Form\RegistrationType;
use App\Security\LoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        // $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', ['error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout()
    {
        return $this->render('test/index.html.twig');

    }
    /**
     * @Route("/registration",name="registration")
     */
    public function Register(Request $request,UserPasswordEncoderInterface $userPasswordEncoder,EntityManagerInterface $manager,sendMail $mailsender)
    {
        $user = new User;
        $form = $this->createForm(RegistrationType::class,$user);
        $form->handleRequest($request);
    
        if($form->isSubmitted() && $form->isValid())
        {   
           $data = $form->getData(); 
           $user->setPassword($userPasswordEncoder->encodePassword($user,$data->getPassword()));
           $user->setRoles(['ROLE_ADMIN']);
           $token = new Token($user);
           $manager->persist($user);
           $manager->persist($token);
           $manager->flush();
           $mailsender->sendmailer($user,$token);
           $this->redirectToRoute('check');
           $this->addFlash('notice',
           "un email de confirmation vous a été envoyé,veuillez cliquer le lien ci-dessus"
        );
        }
        return $this->render('Home/registert.html.twig',['form'=>$form->createView()]);
    }
    /**
     * @Route("confirmation/{value}",name="token_validation",requirements={"page"="\d+"})
     */
    public function confirmation(Token $token1,Request $request,LoginAuthenticator $loginauth ,EntityManagerInterface $manager,GuardAuthenticatorHandler $guard ){
        
        $user = $token1->getUser();
        if($user->getEnable() == true){
            $this->addFlash('notice',"Votre compte est déja vérifié");
        }
        if($token1->isValid()){
        $user->setEnable(true);
        $manager->flush();
        $guard->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $loginauth,
            'main'
        );
        $this->addFlash('notice',"verified account");
       return $this->redirectToRoute('registration');
   
        }

        $manager->remove($token1);
        $manager->remove($user);
        $manager->flush();
        return $this->render('test/index.html.twig');
    }
}
