# Laravel Demo

Project that shows how to develop with Laravel Framework.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

This demo is developed in Docker, so you need download the repository and have Docker installed and running on your machine. After that just fire up your terminal and run:

```
git clone https://github.com/cfaguilera20/laravel-demo.git \
    && cd laravel-demo \
    && docker-compose up -d
```

### Installing

Installing dependencies

```
docker-compose exec microservice_demo_fpm  composer install
```

Creating .env file

```
docker-compose exec microservice_demo_fpm  cp .env.example .env
```

Set DB_HOST=microservice_demo_database in the .env file. 

## Running the tests

Executing phpunit

```
docker-compose exec microservice_demo_fpm  phpunit
```

## Built With

* [Laravel](https://laravel.com/docs/5.7) - The web framework used
* [Composer](https://getcomposer.org/) - Dependency Management
* [Fractal](https://github.com/spatie/laravel-fractal) - Fractal wrapper built for Laravel
* [Entrust](https://github.com/Zizaco/entrust) - Succinct and flexible way to add Role-based Permissions.
* [phpunit-watcher](https://github.com/spatie/phpunit-watcher) - Automatically rerun PHPUnit tests when source code changes.

## Authors

* **Carlos Aguilera** - *Initial work* - [cfaguilera20](https://github.com/cfaguilera20)

