<?php

declare(strict_types=1);

namespace App\Controller\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class testController extends AbstractController
{

    #[Route('/test', name:'test_controller',methods:['GET'])]
    public function testControler(): JsonResponse
    {
        dump("XD");
        return $this->json(['ok'=>'ok']);
    }
}