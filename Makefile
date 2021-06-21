.PHONY: all fix lint test

all: lint test

fix:
	php vendor/bin/php-cs-fixer fix --config=.php_cs

lint:
	php vendor/bin/php-cs-fixer fix --config=.php_cs --dry-run
	php vendor/bin/phpmd src/ text cleancode,codesize,controversial,design,naming,unusedcode
	php vendor/bin/phpmd tests/ text cleancode,codesize,controversial,design,naming,unusedcode

test:
	php vendor/bin/phpunit --configuration phpunit.xml
