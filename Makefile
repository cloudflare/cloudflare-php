THIS := $(realpath $(lastword $(MAKEFILE_LIST)))
HERE := $(shell dirname $(THIS))

.PHONY: all fix lint test

all: lint test

fix:
	php $(HERE)/vendor/bin/php-cs-fixer fix --config=$(HERE)/.php_cs

lint:
	php $(HERE)/vendor/bin/php-cs-fixer fix --config=$(HERE)/.php_cs --dry-run

test:
	php $(HERE)/vendor/bin/phpunit --configuration $(HERE)/phpunit.xml
