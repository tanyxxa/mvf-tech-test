SHELL=/bin/bash

UID := $(shell id -u)
GID := $(shell id -g)

composer-install:
	docker run --rm -it --volume ${PWD}:/app --user ${UID}:${GID} composer install -vvv

composer-update:
	docker run --rm -it --volume ${PWD}:/app --user ${UID}:${GID} composer update -vvv

build:
	docker build --no-cache -t tania/mvf ./

run:
	docker run --rm -it tania/mvf php -f ./index.php $(USERNAME)

test:
	docker run --rm -it tania/mvf php vendor/bin/phpunit tests