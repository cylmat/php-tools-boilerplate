# Php tools boilerplate for tests and linters

Usage
---
Simply clone the repository and use it as a boilerplate for your PHP project.
```
export MY_APP=my_app && \
git clone https://github.com/cylmat/php-tools-boilerplate --depth=1 $MY_APP && \
rm -rf $MY_APP/.git && \
cd $MY_APP && \
unset MY_APP
```
You can then run 
```
make install-all
```
or select or (un)comment the tools you needs

### Linters
* [Codesniffer](https://github.com/squizlabs/PHP_CodeSniffer)
* [Phan](https://github.com/phan/phan/wiki)
* [Php-cs-fixer](https://cs.symfony.com/)
* [Php-parser](https://github.com/nikic/PHP-Parser)
* [Php-parallel-lint](https://github.com/php-parallel-lint/PHP-Parallel-Lint)
* [PhpCpd](https://github.com/sebastianbergmann/phpcpd)
* [PhpMd](https://phpmd.org)

### Behavior
* [Codeception](https://codeception.com)
* [PhpSpec](http://www.phpspec.net)

### Testing
* [Paratest](https://github.com/paratestphp/paratest)
* [PestPhp](https://pestphp.com/)
* [PhpunitGen](https://phpunitgen.io/)
* [PhpUnit](https://phpunit.de/)
* [PhpStan](https://phpstan.org/)

### Automation
* [GrumPhp](https://github.com/phpro/grumphp)
* [Phing](https://phing.info)

### Deployment
* [Deployer](https://deployer.org)

### Versionning
* [Git](http://git-scm.com) Git prompt and alias

## See also
* [cylmat/php-docker-boilerplate](https://github.com/cylmat/php-docker-boilerplate/) - Functional installation of Php environment using Docker containers.
* [Phanan - Htaccess snippets](https://github.com/phanan/htaccess)
* [Phpqa.io - Php Quality Assurance](https://phpqa.io)
