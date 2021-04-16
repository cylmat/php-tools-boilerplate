[![cylmat](https://github.com/cylmat/phpconfig/actions/workflows/main.yml/badge.svg)](https://github.com/cylmat/phpconfig/actions/workflows/main.yml)
[![cylmat](https://circleci.com/gh/cylmat/phpconfig.svg?style=shield)](https://circleci.com/gh/cylmat/phpconfig)
[![codecov](https://codecov.io/gh/cylmat/phpconfig/branch/main/graph/badge.svg?token=H8N2JE4E7J)](https://codecov.io/gh/cylmat/phpconfig)

# Php 7 configuration bootstrap

## Linters
* [Codesniffer v3](https://github.com/squizlabs/PHP_CodeSniffer)
* [Composer-normalize v2](https://github.com/ergebnis/composer-normalize)
* [Phan v4](https://github.com/phan/phan/wiki)
* [Php-cs-fixer v2](https://cs.symfony.com/)
* [Php-parser v4](https://github.com/nikic/PHP-Parser)
* [Php-parallel-lint v1](https://github.com/php-parallel-lint/PHP-Parallel-Lint)
* [PhpCpd v6](https://github.com/sebastianbergmann/phpcpd)
* [PhpMd v2](https://phpmd.org)

## Behavior
* [Codeception v4](https://codeception.com)
* [PhpSpec v7](http://www.phpspec.net)

## Testing
* [Paratest v6](https://github.com/paratestphp/paratest)
* [PestPhp v1](https://pestphp.com/)
* [PhpunitGen v1](https://phpunitgen.io/)
* [PhpUnit v9](https://phpunit.de/)
* [PhpStan v0.12](https://phpstan.org/)

## Coverage
* [Codecov.io](https://codecov.io/)

## Automation
* [GrumPhp v1](https://github.com/phpro/grumphp)
* [Phing v6](https://phing.info)

## Deployment
* [Deployer v6](https://deployer.org)

## Versionning
* [Git v2](http://git-scm.com) Git prompt and alias

Usage
=====
**Download the repository and get the config files you need**  
```
wget -O phpconfig.zip https://github.com/cylmat/phpconfig/archive/refs/heads/main.zip
unzip phpconfig.zip -d vendor/cylmat && rm phpconfig.zip
```

**Or include it in your composer.json and get the files needed**  
```
"repositories": [{ "type": "vcs", 
    "url": "https://github.com/cylmat/phpconfig"
}],
"require": {
    "cylmat/phpconfig":"*"
}
```

#### Ref
* [Cylmat - Dev servers](https://github.com/cylmat/phpserver)    
* [Phanan - Htaccess snippets](https://github.com/phanan/htaccess)
* [Phpqa.io - Php Quality Assurance](https://phpqa.io)
