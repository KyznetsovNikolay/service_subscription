<?php

declare(strict_types=1);

namespace App\Controller;

use App\Module\Subscription\Entity\Subscription;
use App\Module\Subscription\UseCase\Add\Command as AddCommand;
use App\Module\Subscription\UseCase\Add\Form as AddForm;
use App\Module\Subscription\UseCase\Add\Handler as AddHandler;
use App\Module\Subscription\UseCase\Delete\Command as DeleteCommand;
use App\Module\Subscription\UseCase\Delete\Handler as DeleteHandler;
use App\Module\Subscription\UseCase\PayAll\Command;
use App\Module\Subscription\UseCase\PayAll\Handler as PayAllHandler;
use App\Module\User\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/subscription", name="subscription_")
 */
class SubscriptionController extends AbstractController
{

    /**
     * @Route("/{user}/pay", name="pay_all")
     * @param User $user
     * @param PayAllHandler $handler
     * @return Response
     */
    public function payAll(User $user, PayAllHandler $handler): Response
    {
        $command = new Command();
        $command->user = $user;
        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->addFlash('error', $e->getMessage());
        }

        header('Location: /');
        return new Response();
    }

    /**
     * @Route("/{user}/add", name="add")
     * @param Request $request
     * @param User $user
     * @param AddHandler $handler
     * @return Response
     */
    public function addSubscription(Request $request, User $user, AddHandler $handler): Response
    {
        $command = new AddCommand();
        $command->user = $user;

        $form = $this->createForm(AddForm::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
            } catch (\DomainException $e) {
                $this->addFlash('error', $e->getMessage());
            }
            // $this->redirect() и $this->redirectToRoute() не работают
            header(sprintf('Location: /subscription/%s', $user->getId()));
        }

        return $this->render('subscription/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{user}/{subscription}/delete", name="delete")
     * @param User $user
     * @param Subscription $subscription
     * @param DeleteHandler $handler
     * @return Response
     */
    public function deleteSubscription(User $user, Subscription $subscription, DeleteHandler $handler): Response
    {
        $command = new DeleteCommand($subscription, $user);
        $handler->handle($command);

        header(sprintf('Location: /subscription/%s', $user->getId()));

        return new Response();
    }

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
