<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CurrencyExchange extends AbstractController
{
    public function show()
    {
        return $this->render('currencyExchange/show.html.twig', []);
    }
}
