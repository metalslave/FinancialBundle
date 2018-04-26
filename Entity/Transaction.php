<?php

namespace Metalslave\FinancialBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Money\Currency;
use Money\Money;

/**
 * Class Transaction.
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity(repositoryClass="Metalslave\FinancialBundle\Repository\TransactionRepository")
 * @ORM\EntityListeners({
 *     "Metalslave\FinancialBundle\EntityListener\TransactionEntityListener",
 * })
 */
class Transaction
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
     * @var TransactionCategory
     *
     * @ORM\ManyToOne(targetEntity="TransactionCategory")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @var BankAccount
     *
     * @ORM\ManyToOne(targetEntity="BankAccount")
     * @ORM\JoinColumn(name="bank_account_id", referencedColumnName="id")
     *
     * @Assert\NotNull()
     */
    protected $bankAccount;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Assert\GreaterThan(0)
     */
    protected $amount;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $comment;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Tag")
     * @ORM\JoinTable(name="transaction_tags",
     *      joinColumns={@ORM\JoinColumn(name="transaction_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     */
    protected $tags;

    /**
     * Transaction constructor.
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return TransactionCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param TransactionCategory $category
     *
     * @return $this
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return BankAccount
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * @param BankAccount $bankAccount
     *
     * @return $this
     */
    public function setBankAccount($bankAccount)
    {
        $this->bankAccount = $bankAccount;

        return $this;
    }

    /**
     * @return Money
     */
    public function getAmount()
    {
        if (!$this->bankAccount || !$this->bankAccount->getCurrency()) {
            return null;
        }
        $currencyName = $this->getCurrencyName();
        if (!$this->amount) {
            return new Money(0, new Currency($currencyName));
        }

        return new Money($this->amount, new Currency($currencyName));
    }

    /**
     * @return string
     */
    public function getCurrencyName()
    {
        if ($this->bankAccount->getCurrency()) {
            return $this->bankAccount->getCurrency()->getShortName();
        }

        return '';
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
     * @param int $amount
     *
     * @return $this
     */
    public function setAmountInt($amount)
    {
        $this->amount = $amount;

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
        $money = new Money($amount, new Currency($this->getCurrencyName()));

        $this->setAmount($money);

        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     *
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param ArrayCollection $tags
     *
     * @return $this
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @param Tag $tag
     *
     * @return $this
     */
    public function addTag($tag)
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    /**
     * @param Tag $tag
     *
     * @return $this
     */
    public function removeTag($tag)
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }
}
