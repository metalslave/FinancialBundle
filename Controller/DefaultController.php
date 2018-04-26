<?php

namespace Metalslave\FinancialBundle\Controller;

use Metalslave\FinancialBundle\Entity\BankAccount;
use Metalslave\FinancialBundle\Entity\Transaction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="/", name="homepage")
     */
    public function indexAction()
    {
        $bankAccounts = $this->getDoctrine()->getRepository(BankAccount::class)->findAll();
        /** @var BankAccount $bankAccount */
        foreach ($bankAccounts as $bankAccount) {
            $amount = $this->getDoctrine()->getRepository(Transaction::class)
                ->getBankAccountBalanceOnDate($bankAccount, new \DateTime());
            $result = $amount === $bankAccount->getAmountInt();
        }

        return $this->render('MetalslaveFinancialBundle:Default:index.html.twig');
    }
}
