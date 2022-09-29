SHELL := /bin/bash

define all-scripts
	make linter
	make test
endef

all:
	@$(call all-scripts)

# Declare no names like command
# Avoid a conflict with a file of the same name, and improve performance
.PHONY: all all-bin grump-pre linter test

### Test config from host
# docker run --rm -it -v tmpvar:/var/www php:7.4-fpm sh -c "apt update && apt install -y git zip && bash"
###

#######
# BIN #
#######
all-bin:
	make codeception-bin
	make composer-bin
	make deployer-bin
	make kint-bin
	make parallel-bin
	make phan-bin
	make phing-bin
	make phpcsfix-bin
	make phpmd-bin
	make phpstan-bin
	@echo -e "\033[1;32mAll good \033[0m"

# For deployer, environment DEPLOYER_REPOSITORY must be set
# Or use composer require --dev deployer/deployer
codeception-bin:
	curl -L https://codeception.com/codecept.phar -o bin/codecept
	chmod a+x bin/codecept

composer-bin:
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
	php composer-setup.php
	php -r "unlink('composer-setup.php');"
	mv composer.phar bin/composer

deployer-bin:
	curl -L https://github.com/deployphp/deployer/releases/download/v7.0.2/deployer.phar -o bin/deployer
	chmod a+x bin/deployer
	cd bin && ln -s deployer dep

kint-bin:
	curl -L https://raw.githubusercontent.com/kint-php/kint/master/build/kint.phar -o bin/kint
	chmod a+x bin/kint

parallel-bin:
	curl -LO https://github.com/php-parallel-lint/PHP-Parallel-Lint/releases/download/v1.3.2/parallel-lint.phar
	chmod +x parallel-lint.phar
	mv parallel-lint.phar bin/parallel-lint

phan-bin:
	curl -L https://github.com/phan/phan/releases/download/5.4.1/phan.phar -o bin/phan
	chmod +x bin/phan

phing-bin:
	curl -LO https://www.phing.info/get/phing-2.16.4.phar
	curl -LO https://www.phing.info/get/phing-2.16.4.phar.sha512
	sha512sum --check phing-2.16.4.phar.sha512
	rm phing-2.16.4.phar.sha512
	mv phing-2.16.4.phar /usr/local/bin/phing
	chmod +x /usr/local/bin/phing

phpcsfix-bin:
	curl -L https://cs.symfony.com/download/php-cs-fixer-v3.phar -o bin/php-cs-fixer
	chmod a+x bin/php-cs-fixer

phpmd-bin:
	curl -LO https://github.com/phpmd/phpmd/releases/download/2.13.0/phpmd.phar
	chmod a+x phpmd.phar
	mv phpmd.phar bin/phpmd.phar

phpstan-bin:
	curl -L https://github.com/phpstan/phpstan/releases/download/1.8.6/phpstan.phar -o bin/phpstan
	chmod a+x bin/phpstan

# PHIVE
infection-phive:
	phive install infection

### STUBS ###
stubs:
	git clone https://github.com/JetBrains/phpstorm-stubs.git vendor/jetbrains/phpstorm-stubs

###########
# GRUMPHP #
###########

grump-pre: 
	vendor/bin/grumphp git:pre-commit

grump-tasks:
	vendor/bin/grumphp run --tasks=$(ts)

############
# BEHAVIOR #
############

behav:
	make codecept
	make phpspec
	@echo -e "\033[1;32mAll good \033[0m"

codecept:
	bin/codecept run -c tools/test/codeception.yml
	@echo -e "\033[1;32mAll good \033[0m"

phpspec:
	bin/phpspec run --config=tools/test/phpspec.yml
	@echo -e "\033[1;32mAll good \033[0m"

###########
# LINTERS #
###########

# NO autofix before commit on Grumphp
fix:
#	phpparser: Work line by line, use only with GrumPhp
	bin/php-cs-fixer fix --config tools/linter/.php-cs-fixer.php -v
	bin/phpcbf --colors --standard=tools/linter/phpcs.xml -v
	@echo -e "\033[1;32mAll good \033[0m"

linter:
	bin/parallel-lint tests --exclude vendor
	bin/phpcpd src
	bin/phpcs --colors --standard=tools/linter/phpcs.xml -s
	bin/phpmd src ansi tools/linter/phpmd.xml --reportfile=STDOUT
	bin/phpstan analyse --level 8 --configuration tools/linter/phpstan.neon --memory-limit 2G
	make phan
	@echo -e "\033[1;32mAll good \033[0m"

# --allow-polyfill-parser avoid to use ast-ext
phan: 
	bin/phan --config-file tools/linter/phan.config.php --allow-polyfill-parser

###########
# TESTING #
###########

cover:
	XDEBUG_MODE=coverage bin/phpunit -c tools/test/phpunit.xml --coverage-html=var/unit-coverage
	phpdbg -qrr bin/phpunit -c phpunit.xml --coverage-html var/unit-coverage

test-gen:
	bin/phpunitgen --config=tools/test/phpunitgen.yml src

# @see https://pestphp.com
pest:
	bin/pest -c tools/test/phpunit.xml
	@echo -e "\033[1;32mAll good \033[0m"

test:
	bin/paratest -c tools/test/phpunit.xml
#	bin/phpunit -c tools/test/phpunit.xml
	@echo -e "\033[1;32mAll good \033[0m"

############
# BUILDING #
############

phing:
	phing -f tools/build.xml

##########
# DEPLOY #
##########

deploy:
	bin/dep deploy -f tools/deployer.yaml