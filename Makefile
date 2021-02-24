SHELL := /bin/bash

###########
# GRUMPHP #
###########

grump-pre: 
	vendor/bin/grumphp git:pre-commit
	vendor/bin/grumphp run 
	vendor/bin/grumphp run --tasks=$(ts)
	vendor/bin/grumphp run --testsuite=$(ts)

############
# COMPOSER #
############

compose-update:
	composer update --lock
	composer normalize --no-update-lock

###########
# LINTERS #
###########

fix:
	vendor/bin/phpcbf --colors --standard=lint/phpcs.xml -s
	# PHP-cs-fixer: NO autofix before commit on GrumPhp
	vendor/bin/php-cs-fixer fix --config lint/.php_cs
	# phpparser: Work line by line, use only with GrumPhp

linters:
	PHAN_ALLOW_XDEBUG=1 vendor/bin/phan --allow-polyfill-parser --config-file lint/phan.config.php
	vendor/bin/phpcpd src
	vendor/bin/phpcs --colors --standard=lint/phpcs.xml -s
	vendor/bin/parallel-lint src tests --exclude vendor
	vendor/bin/phpmd src ansi lint/phpmd.xml --reportfile=STDOUT
	vendor/bin/phpstan analyse --level 8 --configuration lint/phpstan.neon

###########
# TESTING #
###########

test-gen:
	vendor/bin/phpunitgen --config=config/phpunitgen.yml src tests

cover:
	phpdbg -qrr vendor/bin/phpunit -c config/phpunit.xml --coverage-html var/coverage
	mv var/coverage public/
	  # for one file
	# XDEBUG_MODE=coverage bin/phpunit -c phpunit.xml test/path/ClassTest.php  --coverage-html=var/coverage

testing:
	vendor/bin/infection --configuration=lint/infection.json
	vendor/bin/paratest -c config/phpunit.xml
	  # or
	vendor/bin/pest --configuration config/phpunit.xml
	  # or
	vendor/bin/phpunit --configuration config/phpunit.xml
