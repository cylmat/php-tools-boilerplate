SHELL := /bin/bash

##########################
# Php Quality Assurance  #
#  @see https://phpqa.io #
##########################

define all-scripts
	make all-fix
	make all-linters
	make all-behav 
	make all-tests
	@echo -e "\033[1;32m------------\n- All good -\n------------ \033[0m"
endef

all:
	@$(call all-scripts)
	
install-all:
	make install-all-bin
	make composer-install-dev

.PHONY: install-all-bin composer-install-dev all-fix all-linters all-behav all-tests all-builds grump

### Test config from host
# docker run --rm -it -v tmpvar:/var/www php:7.4-fpm sh -c "apt update && apt install -y git rsync unzip && bash"
###

###########
# INSTALL #
###########

install-all-bin:
	make codeception-bin
	make infection-bin
	make parallel-bin
	make phan-bin
	make csfixer-bin
	make phpmd-bin
	make phpstan-bin
	make psalm-bin
# Utils
	make composer-bin
	make deployer-bin
	make kint-bin
	make phing-bin
	make phive-bin
	make phpenv-bin
	@echo -e "\033[1;32m------------\n- All good -\n------------ \033[0m"
	
# COMPOSER #
composer-install-dev:
	test -e bin/composer || make composer-bin
	bin/composer install --dev
	
###########
# RUN ALL #
###########

all-fix:
	make csfixer
# make cbf

all-linters:
	make paralint
	make cpd
	make cs
	make md
	make stan
	make phan
# make psalm
	@echo -e "\033[1;32m------------\n- All good -\n------------ \033[0m"

all-behav:
	make codecept
	make phpspec
	@echo -e "\033[1;32m------------\n- All good -\n------------ \033[0m"

all-tests:
	make cover
	make infection
	make pest
# make unit
	@echo -e "\033[1;32m------------\n- All good -\n------------ \033[0m"

all-builds:
	make phing

###########
# GRUMPHP #
# @see https://github.com/phpro/grumphp
###########

grump: 
	bin/grumphp run
	@echo -e "\033[1;32m------------\n- All good -\n------------ \033[0m"

grump-tasks:
	bin/grumphp run --tasks=$(ts)

#######
# BIN #
#######

codeception-bin:
	curl -L https://codeception.com/codecept.phar -o bin/codecept
	chmod a+x bin/codecept

csfixer-bin:
	curl -L https://cs.symfony.com/download/php-cs-fixer-v3.phar -o bin/php-cs-fixer
	chmod a+x bin/php-cs-fixer

infection-bin:
	apt update && apt install -y gpg
	curl -L https://github.com/infection/infection/releases/download/0.26.6/infection.phar -o bin/infection
	curl -L https://github.com/infection/infection/releases/download/0.26.6/infection.phar.asc -o /tmp/infection.phar.asc
	gpg --recv-keys C6D76C329EBADE2FB9C458CFC5095986493B4AA0
	gpg --with-fingerprint --verify /tmp/infection.phar.asc bin/infection
	rm /tmp/infection.phar.asc
	chmod +x bin/infection

parallel-bin:
	curl -LO https://github.com/php-parallel-lint/PHP-Parallel-Lint/releases/download/v1.3.2/parallel-lint.phar
	chmod +x parallel-lint.phar
	mv parallel-lint.phar bin/parallel-lint

phan-bin:
	curl -L https://github.com/phan/phan/releases/download/5.4.1/phan.phar -o bin/phan
	chmod +x bin/phan

phpmd-bin:
	curl -L https://github.com/phpmd/phpmd/releases/download/2.13.0/phpmd.phar -o bin/phpmd
	chmod a+x bin/phpmd

phpstan-bin:
	curl -L https://github.com/phpstan/phpstan/releases/download/1.8.6/phpstan.phar -o bin/phpstan
	chmod a+x bin/phpstan

psalm-bin:
	curl -L https://github.com/vimeo/psalm/releases/latest/download/psalm.phar -o bin/psalm
	chmod +x bin/psalm

### Utils ###

# @see https://getcomposer.org
composer-bin:
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
	php composer-setup.php
	php -r "unlink('composer-setup.php');"
	mv composer.phar bin/composer

# @see https://deployer.org
deployer-bin:
	curl -L https://github.com/deployphp/deployer/releases/download/v7.0.2/deployer.phar -o bin/deployer
	chmod a+x bin/deployer
	cd bin && test -f dep || ln -s deployer dep

# @see https://kint-php.github.io
kint-bin:
	curl -L https://raw.githubusercontent.com/kint-php/kint/master/build/kint.phar -o bin/kint
	chmod a+x bin/kint

# @see https://github.com/krakjoe/pcov
pcov-bin:
	pecl install pcov && docker-php-ext-enable pcov

# @see https://phing.info
phing-bin:
	curl -LO https://www.phing.info/get/phing-2.17.4.phar
	curl -LO https://www.phing.info/get/phing-2.17.4.phar.sha512
	sha512sum --check phing-2.17.4.phar.sha512
	rm phing-2.17.4.phar.sha512
	mv phing-2.17.4.phar /usr/local/bin/phing
	chmod +x /usr/local/bin/phing

# PHAR Installation and Verification Environment
# https://phar.io
phive-bin:
	apt update && apt install -y gpg
	curl -L "https://phar.io/releases/phive.phar" -o phive.phar
	curl -L "https://phar.io/releases/phive.phar.asc" -o /tmp/phive.phar.asc 
	gpg --keyserver hkps://keys.openpgp.org --recv-keys 0x6AF725270AB81E04D79442549D8A98B29B2D5D79
	gpg --verify /tmp/phive.phar.asc phive.phar
	rm /tmp/phive.phar.asc
	chmod +x phive.phar
	mv phive.phar /usr/local/bin/phive
	
#########################
# SPECIFIC INSTALL      #
# Not included in 'all' #
#########################
# PHP env #
#@see https://github.com/phpenv/phpenv
phpenv-bin:
	curl -L https://raw.githubusercontent.com/phpenv/phpenv-installer/master/bin/phpenv-installer | bash

# PCOV #
# @see https://github.com/krakjoe/pcov
pcov:
	pecl install pcov && docker-php-ext-enable pcov

# STUBS #
# @see https://github.com/JetBrains
stubs:
	test -d vendor/jetbrains/phpstorm-stubs || \
	git clone https://github.com/JetBrains/phpstorm-stubs.git vendor/jetbrains/phpstorm-stubs

############
# BEHAVIOR #
############

# @see https://codeception.com
codecept:
	bin/codecept run -c tools/test/codeception.yml
	@echo -e "\033[1;32mAll good \033[0m"

# @see http://phpspec.net
phpspec:
	bin/phpspec run --config=tools/test/phpspec.yml
	@echo -e "\033[1;32mAll good \033[0m"

# @see https://docs.behat.org
# behat:

##########
# FIXERS #
# Please use one or other to avoid conflicts
##########

# @see https://cs.symfony.com
csfixer:
	bin/php-cs-fixer fix --config tools/linter/.php-cs-fixer.php -v
	@echo -e "\033[1;32mAll good \033[0m"

# @see https://github.com/squizlabs/PHP_CodeSniffer
cbf:
	bin/phpcbf --colors --standard=tools/linter/phpcs.xml -v

###########
# LINTERS #
###########

# @see https://github.com/php-parallel-lint/PHP-Parallel-Lint
paralint:
	bin/parallel-lint src --exclude vendor

# @see https://github.com/sebastianbergmann/phpcpd
cpd:
	bin/phpcpd src

# @see https://squizlabs.github.io/HTML_CodeSniffer
cs:
	bin/phpcs --colors --standard=tools/linter/phpcs.xml -s

# @see https://phpmd.org
md:
	bin/phpmd src ansi tools/linter/phpmd.xml --reportfile=STDOUT

# @see https://phpstan.org
stan:
	bin/phpstan analyse --level 8 --configuration tools/linter/phpstan.neon --memory-limit 2G

# @see https://github.com/phan/phan/wiki
# --allow-polyfill-parser avoid to use ast-ext
phan: 
	bin/phan --config-file tools/linter/phan.config.php --allow-polyfill-parser

# Caution: can be slow
# @see https://psalm.dev
psalm:
	bin/psalm -c tools/linter/psalm.xml --memory-limit=2G --threads=4

###########
# TESTING #
###########

# @see https://phpunitgen.io
test-gen:
	bin/phpunitgen --config=tools/test/phpunitgen.yml src

cover:
	@echo -e "\033[1;33mYou must install pcov, phpdbg or xdebug to use code coverage \033[0m"
	php -dpcov.enabled=1 bin/phpunit -c tools/test/phpunit.xml --coverage-text tests
#	XDEBUG_MODE=coverage bin/phpunit -c tools/test/phpunit.xml --coverage-html=var/unit-coverage
#	phpdbg -qrr bin/phpunit -c phpunit.xml --coverage-html var/unit-coverage

# @see https://infection.github.io
infection:
	@test -d /tmp/infection || mkdir /tmp/infection
	@test -f /tmp/infection/index.xml || touch /tmp/infection/index.xml
	@echo -e "\033[1;33mYou must install pcov, phpdbg or xdebug to use infection \033[0m"
	bin/infection run -c tools/test/infection.json --debug --show-mutations

# @see https://pestphp.com
pest:
	bin/pest -c tools/test/phpunit.xml

# @see https://github.com/paratestphp/paratest
# @see https://phpunit.de
unit:
	bin/paratest -c tools/test/phpunit.xml
#	bin/phpunit -c tools/test/phpunit.xml

############
# BUILDING #
############

# @see https://www.phing.info
phing:
	phing -f tools/build.xml

##########
# DEPLOY #
##########

# @see https://deployer.org
deploy:
	bin/dep deploy -f tools/deployer.yaml
