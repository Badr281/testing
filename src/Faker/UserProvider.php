<?php
namespace App\Faker;
use App\Entity\User;
use Faker\Generator;
use Faker\Provider\Base;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserProvider extends Base
{
private $userPasswordEncoderInterface;
public function __construct(Generator $generator,UserPasswordEncoderInterface  $userPasswordEncoderInterface){
    parent::__construct($generator);
    $this->userPasswordEncoderInterface = $userPasswordEncoderInterface;
}   
public function testpass($password){ 
return $this->userPasswordEncoderInterface->encodePassword(new User(),$password);

}
}

