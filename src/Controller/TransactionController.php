<?php

declare(strict_types=1);

namespace App\Controller;

use App\Module\Transaction\UseCase\Search\Command as SearchCommand;
use App\Module\Transaction\UseCase\Search\Form as SearchForm;
use App\Module\User\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends AbstractController
{

    /**
     * @Route("/transaction/{user}", name="transaction_list")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function transactionList(User $user, Request $request): Response
    {
        $command = new SearchCommand();

        $form = $this->createForm(SearchForm::class, $command);
        $form->handleRequest($request);
        $transactions = $user->getBalance()->getTransactions();

        if ($form->isSubmitted() && $form->isValid()) {
            $transactions = $user->getBalance()->getTransactionWithParams($command);
        }

        return $this->render('transaction/list.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'transactions' => $transactions,
        ]);
    }
}
