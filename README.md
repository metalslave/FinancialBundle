# FinancialBundle

## Installation

### Add repository to composer.json

```php
[...]
"require" : {
    [...]
    "metalslave/FinancialBundle" : "dev-master"
},
"repositories" : [{
    "type" : "vcs",
    "url" : "https://github.com/metalslave/FinancialBundle.git"
}],
[...]
```
### Add dependency via Composer

```php composer.phar require metalslave/FinancialBundle```

### Register the bundles

To start using the bundle, register it in `app/AppKernel.php`:

```php
public function registerBundles()
{
    $bundles = [
        // Other bundles...
        new Tbbc\MoneyBundle\TbbcMoneyBundle(),
        new Fresh\DoctrineEnumBundle\FreshDoctrineEnumBundle(),
        new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
        
        new Metalslave\FinancialBundle\MetalslaveFinancialBundle(),
    ];
}
```

### Add options to config.yml

```php
tbbc_money:
    currencies: ["USD", "EUR", "UAH", "RUB"]
    reference_currency: "UAH"
    decimals: 2
    ratio_provider: tbbc_money.ratio_provider.google
    storage: doctrine #ratio storage
    enable_pair_history: false

stof_doctrine_extensions:
    orm:
        default:
            timestampable: true
doctrine:
    dbal:
        types:
            CategoryType: Metalslave\FinancialBundle\DBAL\Types\CategoryType
            money: Tbbc\MoneyBundle\Type\MoneyType
twig:
    form_themes:
        - 'TbbcMoneyBundle:Form:fields.html.twig'            
```

### Add options to routing.yml

```php
metalslave_financial:
    resource: "@MetalslaveFinancialBundle/Resources/config/routing.yml"
    prefix:   /
```

### Usage
```php
financial/ - list of links

account_currency/ - creat currencies 
tag/ - create tag
bank_account/ - create bank account
transaction_category/ - create transaction category
transaction/ - create transaction
```