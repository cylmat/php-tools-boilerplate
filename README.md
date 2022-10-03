# Php tools boilerplate for tests and linters

Usage
---
Simply clone the repository and use it as a boilerplate for your PHP project.
```
MY_APP=my_app git clone https://github.com/cylmat/php-tools-boilerplate --depth=1 $MY_APP && \
rm -rf $MY_APP/.git && \
cd $MY_APP
```
You can then run 
```
make install-all
```
or select or (un)comment the tools you needs

### Linters
* [Codesniffer v3](https://github.com/squizlabs/PHP_CodeSniffer)
* [Composer-normalize v2](https://github.com/ergebnis/composer-normalize)
* [Phan v4](https://github.com/phan/phan/wiki)
* [Php-cs-fixer v2](https://cs.symfony.com/)
* [Php-parser v4](https://github.com/nikic/PHP-Parser)
* [Php-parallel-lint v1](https://github.com/php-parallel-lint/PHP-Parallel-Lint)
* [PhpCpd v6](https://github.com/sebastianbergmann/phpcpd)
* [PhpMd v2](https://phpmd.org)

### Behavior
* [Codeception v4](https://codeception.com)
* [PhpSpec v7](http://www.phpspec.net)

### Testing
* [Paratest v6](https://github.com/paratestphp/paratest)
* [PestPhp v1](https://pestphp.com/)
* [PhpunitGen v1](https://phpunitgen.io/)
* [PhpUnit v9](https://phpunit.de/)
* [PhpStan v0.12](https://phpstan.org/)

### Automation
* [GrumPhp v1](https://github.com/phpro/grumphp)
* [Phing v6](https://phing.info)

### Deployment
* [Deployer v6](https://deployer.org)

### Versionning
* [Git v2](http://git-scm.com) Git prompt and alias

## See also
* [cylmat/phpserver](https://github.com/cylmat/phpserver/) - Functional installation of Php environment using Docker containers.
* [Phanan - Htaccess snippets](https://github.com/phanan/htaccess)
* [Phpqa.io - Php Quality Assurance](https://phpqa.io)
