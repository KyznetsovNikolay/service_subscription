<?php

declare(strict_types=1);

namespace App\Controller;

use App\Module\Balance\UseCase\Add\Command;
use App\Module\Balance\UseCase\Add\Form;
use App\Module\Balance\UseCase\Add\Handler;
use App\Module\User\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BalanceController extends AbstractController
{
    /**
     * @Route("/balanse/{user}/add", name="balance_add")
     * @param User $user
     * @param Request $request
     * @param Handler $handler
     * @return Response
     */
    public function replenishment(User $user, Request $request, Handler $handler): Response
    {
        $command = new Command();
        $command->user = $user;

        $form = $this->createForm(Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $handler->handle($command);
            header('Location: /');
        }

        return $this->render('balance/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
