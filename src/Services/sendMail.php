<?php
namespace App\Services;
use App\Entity\User;
use App\Entity\Token;

class sendMail {
  private $twig;
  private $mailer;  
public function __construct(\Twig_Environment $twig,\Swift_Mailer $mailer){
$this->twig = $twig;
$this->mailer =$mailer;
}
public function sendmailer(User $user,Token $token)
{
  $message = ( new \Swift_Message("veuillez confirmer l'inscription"))
    ->setFrom("morad28138@gmail.com")
    ->setTo($user->getEmail())
    ->setBody(
        $this->twig->render('test/sendMailer.html.twig',['token'=>$token->getValue()]),
        'text/html'
    );
    $this->mailer->send($message);  
    
}


}