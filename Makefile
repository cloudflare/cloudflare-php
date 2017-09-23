THIS := $(realpath $(lastword $(MAKEFILE_LIST)))
HERE := $(shell dirname $(THIS))

.PHONY: all fix test

all: fix test

fix:
	php $(HERE)/vendor/bin/php-cs-fixer fix --config=$(HERE)/.php_cs

test:
	php $(HERE)/vendor/bin/phpunit --configuration $(HERE)/phpunit.xml
