<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    /**
     * @Route("/", name="test")
     */
    public function index()
    {
        $token = new \DateTime();
        return $this->render('Home/index.html.twig', [
            'token'=>$token->format('H:i:s \O\n Y-m-d')
        ]);
    }
    /**
     * @Route("/check",name="check")
     */
    public function check()
    {
        return $this->render('test/index.html.twig');
    }
    /**
     * @Route("/nav",name="nav")
     */
    public function nav()
    {
        return $this->render('landing/base.html.twig');
    }
}
