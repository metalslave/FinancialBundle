<?php

namespace Metalslave\FinancialBundle\EntityListener;

use Metalslave\FinancialBundle\Entity\Transaction;
use Metalslave\FinancialBundle\Event\UpdateBankAccountEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class TransactionEntityListener.
 */
class TransactionEntityListener
{
    /** @var EventDispatcherInterface */
    private $dispatcher;

    /**
     * EventPointEntityListener constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param Transaction $object
     */
    public function postPersist(Transaction $object)
    {
        if ($object instanceof Transaction) {
            $this->dispatcher->dispatch('event.update_bank_account_amount', new UpdateBankAccountEvent(
                $object->getBankAccount(),
                $object->getCategory(),
                $object->getAmount()->getAmount()
            ));
        }
    }
}
