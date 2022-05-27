# enkaizen-laravel-challenge
A laravel challenge project given by the company Enkaizen (image storing webapp)

## Installation

You must have npm and composer installed.

* run `npm install`
* run `composer install`
* configure database credentials and broadcast credentials in env file
* run `php artisan store:link`
* run `php artisan migrate`

## Run the app

(you have to have 4 terminals open and run these following commands in each of your terminal)

* `php artisan serve`
* `npm run watch`
* `php artisan websockets:serve`
* `php artisan queue:listen`

visit `http://127.0.0.1:8000` and enjoy.
