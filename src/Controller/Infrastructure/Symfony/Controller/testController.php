<?php

declare(strict_types=1);

namespace App\Controller\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class testController extends AbstractController
{

    #[Route('/test', name:'test_controller',methods:['GET'])]
    public function testControler(): Response
    {
        return $this->render('login.html.twig', [
            'choice' => [
                'jebane',
                'psy',
                'jebac jak 150'
            ],
            'tytul' => 'Jebana kurewka'
        ]);
    }
}