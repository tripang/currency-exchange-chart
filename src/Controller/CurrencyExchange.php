<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Rate;

class CurrencyExchange extends AbstractController
{
    public function show()
    {
        return $this->render('currencyExchange/show.html.twig', []);
    }
}
