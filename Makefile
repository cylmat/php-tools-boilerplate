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

#######
# BIN #
#######

# For deployer, environment DEPLOYER_REPOSITORY must be set
deployer-bin:
	curl -LO https://deployer.org/releases/v6.8.0/deployer.phar
	mv deployer.phar /usr/local/bin/dep
	chmod +x /usr/local/bin/dep
	dep -V -f -

kint-bin:
	# or by "composer require --dev kint-php/kint"
	curl -LO https://raw.githubusercontent.com/kint-php/kint/master/build/kint.phar
	mkdir bin -p && mv kint.phar bin

phing-bin:
	curl -LO https://www.phing.info/get/phing-2.16.4.phar
	curl -LO https://www.phing.info/get/phing-2.16.4.phar.sha512
	sha512sum --check phing-2.16.4.phar.sha512
	rm phing-2.16.4.phar.sha512
	mv phing-2.16.4.phar /usr/local/bin/phing
	chmod +x /usr/local/bin/phing
	phing -v

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