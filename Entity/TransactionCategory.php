<?php

namespace Metalslave\FinancialBundle\Entity;

use Metalslave\FinancialBundle\DBAL\Types\CategoryType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

/**
 * Class TransactionCategory.
 *
 * @ORM\Table(name="transaction_category")
 * @ORM\Entity()
 */
class TransactionCategory
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
     * @var
     *
     * @ORM\Column(name="category_type", type="CategoryType", nullable=false)
     *
     * @DoctrineAssert\Enum(entity="Metalslave\FinancialBundle\DBAL\Types\CategoryType")
     */
    protected $categoryType;

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
     * @return mixed
     */
    public function getCategoryType()
    {
        return $this->categoryType;
    }

    /**
     * @param mixed $categoryType
     *
     * @return $this
     */
    public function setCategoryType($categoryType)
    {
        $this->categoryType = $categoryType;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (null !== $this->id) {
            return CategoryType::getReadableValue($this->categoryType).': '.$this->getName();
        }

        return '';
    }
}
