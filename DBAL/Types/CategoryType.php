<?php

namespace Metalslave\FinancialBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class CategoryType
 */
class CategoryType extends AbstractEnumType
{
    const INCOME = 'income';
    const OUTCOME = 'outcome';

    protected static $choices = [
        self::INCOME  => 'прихід',
        self::OUTCOME  => 'розхід',
    ];
}
