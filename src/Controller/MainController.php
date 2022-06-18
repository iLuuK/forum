<?php

namespace App\Controller;

use App\Controller\Trait\RoleTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    use RoleTrait;

    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        if ($response = $this->checkRole('ROLE_USER')) {
            return $this->render('main/extern.html.twig');
        }
        return $this->render('main/intern.html.twig');
    }
}

