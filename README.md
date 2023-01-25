New Living - Web App/API
================

The software is called New Living. 
It was created as part of an engineering thesis for an engineering computer science degree at Nicolaus Copernicus University in Torun, Poland.
The application is based on Symfony 6.1.3 framework and on Twig.

## System requirements

To be able to run it you need PHP 8.1, composer, opcache and zip extension.
But I provide docker image and docker-compose file so anyone can run this project.
Tested on docker 20.10.21 and docker-compose 1.29.2.
You can use `make` to run some dev scripts.
If you don't want to install the `make` tool, you can see all the commands being executed in the file [Makefile](Makefile).

## Endpoint documentation
Endpoint documentation is available by starting the project and going to http://lvh.me/doc

## Repository of a sample IoT module
A repository of a sample IoT module is available [here](https://github.com/CezikLikeWhat/new-living-led-ring)

## Installation

All in one:
```bash
make install
```
Or:
```bash
make build
make up
make composer
```
__After launching the project, go to http://lvh.me__
## Testing

I have some tests written in PHPunit and Behat. To run such tests please start service `make up`,
run `make preparedbtest` then run `make test`. You can as well login into bash using `make bash` and
then execute test using `vendor/bin/phpunit tests` command 
