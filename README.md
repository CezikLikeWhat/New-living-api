New Living - API
================

An application designed to automate the process of managing the Multisport program at ITEO.
The options it will provide are: adding a card, deleting a card, changing the plan, generating a report.
The application is based on Symfony 6.1.3 framework and on Twig.

## System requirements

To be able to run it you need PHP 8.1, composer, opcache and zip extension.
But I provide docker image and docker-compose file so anyone can run this project.
Tested on docker 20.10.17 and docker-compose 1.29.2.
We use `make` to run some dev scripts, if you do not want to install `make` please verify our [Makefile](Makefile).

## Installation

All in one:
```
make install
```
Or:
```
make build
make up
make composer
```

## Testing

I have some tests written in PHPunit. To run such tests please start service `make up`,
run `make preparedbtest` then run `make test`. You can as well login into bash using `make bash` and
then execute test using `vendor/bin/phpunit tests` command 

