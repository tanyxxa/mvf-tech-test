FROM php:7.4.8-cli-alpine3.12

COPY . /usr/src/myapp
WORKDIR /usr/src/myapp
