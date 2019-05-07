<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AgencyRepository;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(AgencyRepository $ar)
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'agencies'=>$ar->findAll()
        ]);
    }
}
