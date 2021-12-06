<?php

declare(strict_types=1);

namespace App\Controller;

use App\Module\User\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/subscription", name="subscription_")
 */
class SubscriptionController extends AbstractController
{

    /**
     * @Route("/{user}", name="list")
     * @param User $user
     * @return Response
     */
    public function subscriptionList(User $user): Response
    {
        return $this->render('subscription/list.html.twig', [
            'user' => $user
        ]);
    }
}
