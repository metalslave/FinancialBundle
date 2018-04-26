<?php

namespace Metalslave\FinancialBundle\Event;

use Metalslave\FinancialBundle\Entity\BankAccount;
use Metalslave\FinancialBundle\Entity\TransactionCategory;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class UpdateBankAccountEvent.
 */
class UpdateBankAccountEvent extends Event
{
    /** @var int */
    private $amount;

    /** @var TransactionCategory */
    private $category;

    /** @var BankAccount */
    private $bankAccount;

    /**
     * UpdateBankAccountEvent constructor.
     *
     * @param BankAccount         $bankAccount
     * @param TransactionCategory $category
     * @param int                 $amount
     */
    public function __construct($bankAccount, $category, $amount)
    {
        $this->bankAccount = $bankAccount;
        $this->amount = $amount;
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return TransactionCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return BankAccount
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }
}
