SHELL := /bin/bash

define see-cron
	cat /var/log/cron.log
endef

tests:
	symfony console doctrine:fixtures:load -n
	symfony php bin/phpunit
.PHONY: tests

install-cron:
	apt update
	apt install -y rsync cron

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
	# php-cs-fixer: NO autofix before commit on GrumPhp
	bin/php-cs-fixer fix --config lint/.php_cs
	# phpparser: Work line by line, use only with GrumPhp

linters:
	PHAN_ALLOW_XDEBUG=1 bin/phan --allow-polyfill-parser --config-file lint/phan.config.php
	bin/phpcpd src
	bin/phpcs src --colors --standard=lint/phpcs.xml
	bin/parallel-lint src tests --exclude vendor

	# PHPMD /path/to/source report_format ruleset --reportfile=reports/phpmd.log
	bin/phpmd src ansi lint/phpmd.xml --reportfile=STDOUT
	bin/phpmnd src config
	bin/phpstan analyse --level 8 --configuration lint/phpstan.neon

psalm:
	# PSALM - really slow
	bin/psalm

###########
# TESTING #
###########
test-gen:
	bin/phpunitgen --config=config/phpunitgen.yml src tests

cover:
	phpdbg -qrr bin/phpunit -c config/phpunit.xml --coverage-html var/coverage
	mv var/coverage public/
	  # one file
	# XDEBUG_MODE=coverage bin/phpunit -c phpunit.xml test/path/ClassTest.php  --coverage-html=var/coverage

testing:
	bin/infection --configuration=lint/infection.json
	bin/phpunit --configuration config/phpunit.xml
	  # or
	bin/pest --configuration config/phpunit.xml
	  # or (phpunit in parallele)
	bin/paratest -c config/phpunit.xml

###########
# SYMFONY #
###########
# symfony/maker-bundle + doctrine/annotations + orm

# RSYNC
rsync:
	rsync --archive -vz --update /var/www/ /var/SYMFONY >> /var/log/cron.log 2>&1 \
		--exclude "node_modules" \
		--exclude "vendor" \
		--exclude ".data" 
		--exclude ".git"

set-cron-rsync:
	echo "*/3 * * * * rsync --archive -vz --update /var/www/src/ /var/SYMFONY/src >> /var/log/cron.log 2>&1" >> /etc/crontab
	service cron start

clean:
	rm -rf var/cache/*
	rm -rf var/logs/*
	chmod -R 777 var/

d-see-cron:
	@$(call see-cron)
