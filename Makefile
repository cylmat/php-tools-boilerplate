SHELL := /bin/bash

# define aaa
# 	 my_shell_script -arg "${1}"
# endef
#
# daemon-aaa:
#    @$(call aaa, and aaa, and aaa)

# Call when no arguments
all:
	@echo '';

# Declare no names like command
# Avoid a conflict with a file of the same name, and improve performance
.PHONY: all grump-pre linters testing

### Test config from host
# docker run --rm -it -v tmpvar:/var/www php:7.4-fpm sh -c "apt update && apt install -y zip git && bash"
###

###############
# HOME CONFIG #
###############

# BASH
bash-it:
	git clone --depth=1 https://github.com/Bash-it/bash-it.git ~/.bash_it && ~/.bash_it/install.sh

info-git:
	git clone https://github.com/magicmonty/bash-git-prompt.git ~/.bash-git-prompt --depth=1

# VIM
ultimate-vim:
	git clone --depth=1 https://github.com/amix/vimrc.git ~/.vim_runtime
	# sh ~/.vim_runtime/install_basic_vimrc.sh
	# sh ~/.vim_runtime/install_awesome_vimrc.sh
	# sh ~/.vim_runtime/install_amesome_parameterized.sh

#######
# BIN #
#######

# For deployer, environment DEPLOYER_REPOSITORY must be set
# Or use composer require --dev deployer/deployer
composer-bin:
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
	php composer-setup.php
	php -r "unlink('composer-setup.php');"
	mv composer.phar /usr/local/bin/composer

deployer-bin:
	curl -LO https://github.com/deployphp/deployer/releases/download/v7.0.2/deployer.phar
	mv deployer.phar /usr/local/bin/dep
	chmod +x /usr/local/bin/dep

deployer-install:
	alias dep='vendor/bin/dep'
	dep completion bash > /etc/bash_completion.d/deployer

kint-bin:
	curl -LO https://raw.githubusercontent.com/kint-php/kint/master/build/kint.phar
	mkdir bin -p && mv kint.phar bin

phing-bin:
	curl -LO https://www.phing.info/get/phing-2.16.4.phar
	curl -LO https://www.phing.info/get/phing-2.16.4.phar.sha512
	sha512sum --check phing-2.16.4.phar.sha512
	rm phing-2.16.4.phar.sha512
	mv phing-2.16.4.phar /usr/local/bin/phing
	chmod +x /usr/local/bin/phing

phpstan-bin:
	curl -LO https://github.com/phpstan/phpstan/releases/download/1.8.6/phpstan.phar

### 
# PHIVE
###
infection-phive:
	phive install infection

###########
# GRUMPHP #
###########

grump-behav:
	vendor/bin/grumphp run --testsuite=behav

grump-lint:
	vendor/bin/grumphp run --testsuite=lint

grump-tests:
	vendor/bin/grumphp run --testsuite=tests

grump-pre: 
	vendor/bin/grumphp git:pre-commit

grump-tasks:
	vendor/bin/grumphp run --tasks=$(ts)

############
# COMPOSER #
############

compose-update:
	composer update --lock
	composer normalize --no-update-lock

############
# BEHAVIOR #
############

behav:
	# Behavior and acceptance
	make codecept
	make phpspec

codecept:
	# Browser acceptance
	vendor/bin/codecept generate:cest acceptance sample -q || exit 0
	vendor/bin/codecept run -c codeception.yml

	# BDD features acceptance
	vendor/bin/codecept g:feature acceptance sample -q || exit 0
	vendor/bin/codecept gherkin:snippets acceptance
	vendor/bin/codecept gherkin:steps acceptance
	vendor/bin/codecept run acceptance sample.feature

phpspec:
	echo 'N' | vendor/bin/phpspec describe App/Sample -q --config=phpspec.yml
	vendor/bin/phpspec run --config=phpspec.yml

###########
# LINTERS #
###########

# NO autofix before commit on GrumPhp
fix:
	vendor/bin/php-cs-fixer fix --config lint/.php_cs -v
	vendor/bin/phpcbf --colors --standard=lint/phpcs.xml -v
	# phpparser: Work line by line, use only with GrumPhp

# Only used with make cause require 'php-ast' extension
phan:
	PHAN_ALLOW_XDEBUG=1 vendor/bin/phan --allow-polyfill-parser --config-file lint/phan.config.php

linters:
	make phan
	vendor/bin/phpcpd src
	vendor/bin/phpcs --colors --standard=lint/phpcs.xml -s
	vendor/bin/parallel-lint src --exclude vendor
	vendor/bin/phpmd src ansi lint/phpmd.xml --reportfile=STDOUT
	vendor/bin/phpstan analyse --level 8 --configuration lint/phpstan.neon --memory-limit 256M

###########
# TESTING #
###########

test-gen:
	vendor/bin/phpunitgen --config=phpunitgen.yml src

phpunit:
	vendor/bin/phpunit -c phpunit.xml

cover:
	XDEBUG_MODE=coverage vendor/bin/phpunit -c phpunit.xml --coverage-html=var/unit-coverage
	phpdbg -qrr vendor/bin/phpunit -c phpunit.xml --coverage-html var/unit-coverage

testing:
	# paratest, pest or phpunit
	vendor/bin/paratest -c phpunit.xml
	vendor/bin/pest -c phpunit.xml
	make phpunit

############
# BUILDING #
############

phing:
	phing -f ./build.xml

##########
# DEPLOY #
##########

deployer:
	dep deploy