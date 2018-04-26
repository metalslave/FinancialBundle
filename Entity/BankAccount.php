<?php

namespace Metalslave\FinancialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Money\Currency;
use Money\Money;

/**
 * Class BankAccount.
 *
 * @ORM\Table(name="bank_account")
 * @ORM\Entity(repositoryClass="Metalslave\FinancialBundle\Repository\BankAccountRepository")
 */
class BankAccount
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     *
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var AccountCurrency
     *
     * @ORM\ManyToOne(targetEntity="AccountCurrency")
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     */
    protected $currency;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $amount;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     *
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return Money
     */
    public function getAmount()
    {
        if (!$this->currency) {
            return null;
        }
        if (!$this->amount) {
            return new Money(0, new Currency($this->currency->getShortName()));
        }

        return new Money($this->amount, new Currency($this->currency->getShortName()));
    }

    /**
     * @return int
     */
    public function getAmountInt()
    {
        $money = $this->getAmount();
        if ($money) {
            return $money->getAmount();
        }

        return 0;
    }

    /**
     * @param Money $amount
     *
     * @return $this
     */
    public function setAmount(Money $amount)
    {
        $this->amount = $amount->getAmount();

        return $this;
    }

    /**
     * @param int|float $amount
     *
     * @return $this
     *
     * @throws \Money\UnknownCurrencyException
     */
    public function setAmountNumber($amount)
    {
        $money = new Money($amount, new Currency($this->currency->getShortName()));

        $this->setAmount($money);

        return $this;
    }
}
