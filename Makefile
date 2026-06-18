.PHONY: all fix lint test

all: lint test

fix:
	php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php

lint:
	php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php --dry-run
	php vendor/bin/phpmd src/ text phpmd.xml
	php vendor/bin/phpmd tests/ text phpmd.xml

test:
	php vendor/bin/phpunit --configuration phpunit.xml
