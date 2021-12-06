<?php

declare(strict_types=1);

namespace App\Controller;

use App\Module\User\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="profile")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function profile(UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(['id' => 1]);

        return $this->render('profile.html.twig', [
            'user' => $user,
        ]);
    }
}
