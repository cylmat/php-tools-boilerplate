###########
# GRUMPHP #
###########

grump-pre: 
	bin/grumphp git:pre-commit
	bin/grumphp run 
	bin/grumphp run --tasks=$(ts)
	bin/grumphp run --testsuite=$(ts)

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
	# PHP-cs-fixer: NO autofix before commit on GrumPhp
	bin/php-cs-fixer fix --config lint/.php_cs
	# phpparser: Work line by line, use only with GrumPhp

linters:
	PHAN_ALLOW_XDEBUG=1 bin/phan --allow-polyfill-parser --config-file lint/phan.config.php
	bin/phpcpd src
	bin/phpcs --colors --standard=lint/phpcs.xml -s
	bin/parallel-lint src tests --exclude vendor
	bin/phpmd src ansi lint/phpmd.xml --reportfile=STDOUT
	bin/phpstan analyse --level 8 --configuration lint/phpstan.neon

###########
# TESTING #
###########

test-gen:
	bin/phpunitgen --config=config/phpunitgen.yml src tests

cover:
	phpdbg -qrr bin/phpunit -c config/phpunit.xml --coverage-html var/coverage
	mv var/coverage public/
	  # for one file
	# XDEBUG_MODE=coverage bin/phpunit -c phpunit.xml test/path/ClassTest.php  --coverage-html=var/coverage

testing:
	bin/infection --configuration=lint/infection.json
	bin/paratest -c config/phpunit.xml
	  # or
	bin/pest --configuration config/phpunit.xml
	  # or
	bin/phpunit --configuration config/phpunit.xml
