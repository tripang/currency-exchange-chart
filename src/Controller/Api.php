<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Rate;

class Api extends AbstractController
{
    public function usd()
    {
        $rates = $this->getDoctrine()
            ->getRepository(Rate::class)
            ->findUsd();

        return $this->json($rates);
    }

    public function eur()
    {
        $rates = $this->getDoctrine()
            ->getRepository(Rate::class)
            ->findEur();

        return $this->json($rates);
    }
}
