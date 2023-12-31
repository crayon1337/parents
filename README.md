<h1 align="center">Parents</h1>

## About Parents
Parents is a simple API application that would collect data from several providers and expose the data collected via an API. Also, the user might filter the data returned with several properties.

## Prerequisites
- [PHP 8.2](https://www.php.net/releases/8.2/en.php)
- [Docker](https://www.docker.com/)

The application Docker container is using Ubuntu 22.04

## Installation
- Clone this repository
- Build the application docker container using
```bash 
$ docker-compose build app
```
- Run the environment in background
```bash
$ docker-compose up -d 
```
- Install the project
```bash 
$ cd parents
$ docker-compose exec app cp .env.example .env
$ docker-compose exec app composer install
$ docker-compose exec app php artisan key:generate
```
- The application will be accessible on `http://localhost:8000`

## Data Providers
The current supported data providers are X and Y and both of them provides data to our application through JSON files.

You may setup new providers as needed. You just have to implement a method that would return collection of data and append that provider to the providers array in TransactionService
## Coding Standards
Following [PSR-12](https://www.php-fig.org/psr/psr-12/) which is the most famous coding standards for PHP out there. Which means, that would make the maintenance of this application a lot easier for various developers.

I will also be using [Laravel Pint](https://laravel.com/docs/10.x/pint) in order to maintain PSR-12 within this project.

If you would like to fix the errors detected within your application
```bash 
$ ./vendor/bin/pint
```

If you would like Pint to simply inspect your code for style errors without actually changing the files, you may use the --test option:
```bash
$ ./vendor/bin/pint --test 
```

## Tests
Flow Test cases: 
- Assert that the API documentation route is accessible on /api/docs.
- Assert that the providers data are readable. And it is possible to map the data to DTOs. 
- Assert that by default the API would expose all users collected from different providers
- Assert that it is possible to filter returned users by the given provider
- Assert that the endpoint will return 422 if the given provider is too long
- Assert that it is possible to filter the users status code (authorized, decline, refunded)
- Assert that the endpoint will return 422 if the given status is invalid
- Assert that it is possible to filter the users using balance (Min and Max)
- Assert that the endpoint will return 422 if the given balanceMax is lower than balanceMin
- Assert that it is possible to filter the users using currency
- Assert that it is possible to combine all filters together

## API versioning
The current stable release of this application's API is `Version 1`. 

That being said, the API routes of this application will be prefixed with `/api/v1`

## API documentation
This application uses [Swagger](https://swagger.io/) to document its APIs.

Swagger documentation will be available at `http://localhost:8000/api/docs`

## CI - CD
This application uses [GitHub Actions](https://docs.github.com/en/actions) to verify that everything is green on commits to the `main` branch.

## Disclaimer
I've had good experience solving this problem as it tackles several concerns to handle.

However, I think the route should've been named `/transactions` since we are actually returning transactions, and we do not have data scheme for users.
I could have prepared users data using the emails in the transactions scheme. But, I just want to stick to the scope of this problem.
