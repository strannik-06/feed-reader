Feed Reader - application that can read and parse large xml and display results in user-friendly way.

## Technologies
 - PHP 5.6
 - Symfony 2.7
 - AngularJS 1.4
 - Bootstrap 3.3.5

## Installation

`composer install`

`php app/console assetic:dump --env=prod --no-debug`

`php app/console assets:install`

## Usage
Run built-in web server:

`php app/console server:start`

Open http://127.0.0.1:8000/ 

## Running tests

`phpunit -c app/phpunit.xml.dist`
