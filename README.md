# Php tools boilerplate for tests and linters

Usage
---
* Simply clone the repository and use it as a boilerplate for your PHP project.
```
export APP_DIR=app_dir && \
git clone https://github.com/cylmat/php-tools-boilerplate --depth=1 $APP_DIR && \
rm -rf $APP_DIR/.git && \
cd $APP_DIR && \
unset APP_DIR
```
or if your directory is NOT empty
```
export APP_DIR=. && \
mkdir -p $APP_DIR && \
curl -L https://github.com/cylmat/php-tools-boilerplate/archive/refs/heads/main.zip -o /tmp/main.zip && \
unzip /tmp/main.zip -d /tmp && \
mv /tmp/php-tools-boilerplate-main/* $APP_DIR && \
rm -rf /tmp/php-tools-boilerplate-main && \
unset APP_DIR
```
* You can then run 
```
make install-all
```
or select or (un)comment the tools you needs.

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
