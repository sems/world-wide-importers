# world-wide-importers
groep project 'world wide importers'

## Requirements
* NodeJs
* SASS
* Local development environment
* Composer

#### Install 
* Installation requires PHP 7.1+
* You may need to install NodeJs first (if not already installed)
* You may need to install Composer first

* Then install required Node packages for development with:
  * `npm install -g sass`
  * `npm install -g localtunnel`
  
* Install the composer required composer packages:
  * `$ composer require mollie/mollie-api-php:^2.0`
  * `$ composer require "swiftmailer/swiftmailer:^6.0"`

## Getting started

Be in the `/src` folder when executing the following commands in your terminal
* Watch Sass file `sass --watch scss/main.scss css/main.css`.
* Run webserver `lt --port [local webserverport]` 
* Go to your local dev env `[DOCROOT]/src`.
* Add your password to `inc/password.php`

## Email function
* Include following: `include 'inc/functions.php';`
* Then send email as following: `sendEmail("test@example.com", "John Doe", "Subject", "Body");`
