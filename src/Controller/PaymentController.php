<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends AbstractController
{
    protected PaymentRepository $repository;

    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function payments(): Response
    {
        return $this->render('payments.html.twig', [
           'revenue_per_currency' => $this->repository->revenuePerCurrency(),
           'revenue_per_user' => $this->repository->revenuePerUser(),
           'revenue_euro_per_day' => $this->repository->revenueEuroPerDay(),
       ]);
    }
}
