<?php

namespace Metalslave\FinancialBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Metalslave\FinancialBundle\DBAL\Types\CategoryType;
use Metalslave\FinancialBundle\Entity\BankAccount;
use Metalslave\FinancialBundle\Entity\Transaction;

/**
 * Class TransactionRepository.
 */
class TransactionRepository extends EntityRepository
{
    /**
     * @param BankAccount      $bankAccount
     * @param \DateTime|string $onDate
     *
     * @return int
     */
    public function getBankAccountBalanceOnDate($bankAccount, $onDate)
    {
        $onDateStr = '';
        if ($onDate instanceof \DateTime) {
            $onDateStr = $onDate->format('Y-m-d H:i:s');
        } elseif (is_string($onDate)) {
            $onDateStr = $onDate;
        }

        $qb = $this->createQueryBuilder('t');
        $transactions = $qb->where($qb->expr()->lte('t.createdAt', ':on_date'))
            ->andWhere($qb->expr()->eq('t.bankAccount', ':bank_account'))
            ->setParameters(['on_date' => $onDateStr, 'bank_account' => $bankAccount])
            ->getQuery()
            ->getResult();

        $result = ['out' => 0, 'in' => 0];
        /** @var Transaction $transaction */
        foreach ($transactions as $transaction) {
            if ($transaction->getCategory()->getCategoryType() === CategoryType::OUTCOME) {
                $result['out'] += $transaction->getAmount()->getAmount();
            } else {
                $result['in'] += $transaction->getAmount()->getAmount();
            }
        }

        return $result['in'] - $result['out'];
    }
}
