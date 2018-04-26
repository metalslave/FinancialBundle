<?php

namespace Metalslave\FinancialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AccountCurrency.
 *
 * @ORM\Table(name="account_currency")
 * @ORM\Entity()
 */
class AccountCurrency
{
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
     * @ORM\Column(type="string", length=10, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Currency()
     */
    protected $shortName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64, nullable=true)
     *
     * @Assert\NotBlank()
     */
    protected $name;

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
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * @param string $shortName
     *
     * @return $this
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->id) {
            return $this->name.' '.$this->shortName;
        }

        return 'null';
    }
}
