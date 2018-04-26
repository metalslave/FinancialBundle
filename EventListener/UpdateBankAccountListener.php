<?php

namespace Metalslave\FinancialBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Metalslave\FinancialBundle\DBAL\Types\CategoryType;
use Metalslave\FinancialBundle\Entity\BankAccount;
use Metalslave\FinancialBundle\Entity\TransactionCategory;
use Metalslave\FinancialBundle\Event\UpdateBankAccountEvent;

/**
 * Class UpdateBankAccountListener.
 */
class UpdateBankAccountListener
{
    /** @var EntityManager */
    private $em;

    /**
     * UpdateVenueHallListener constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param UpdateBankAccountEvent $arg
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Money\UnknownCurrencyException
     */
    public function onUpdateAccountAmount(UpdateBankAccountEvent $arg)
    {
        $amount = $arg->getAmount();
        $category = $arg->getCategory();
        $bankAccount = $arg->getBankAccount();

        if ($category instanceof TransactionCategory && $bankAccount instanceof BankAccount && is_numeric($amount)) {
            if (CategoryType::OUTCOME === $category->getCategoryType()) {
                $amount = -$amount;
            }

            $currentAmount = $bankAccount->getAmount()->getAmount();
            $currentAmount += $amount;
            $bankAccount->setAmount($currentAmount);

            $this->em->flush($bankAccount);
        }
    }
}
