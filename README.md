# world-wide-importers
groep project 'world wide importers'

## Requirements
* NodeJs
* SASS
* Local development environment
* Composer

#### Install 
* You may need to install NodeJs first (if not already installed):
* You may need to install Composer first:
  - Cd to source directory and then:
  - `php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '93b54496392c062774670ac18b134c3b3a95e5a5e5c8f1a9f115f203b75bf9a129d5daa8ba6a13e2cc8a1da0806388a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"`
* Install swiftmailer with:
  * `./composer.phar require "swiftmailer/swiftmailer:^6.0"`
* Then install Sass with:
  * `npm install -g sass`

## Getting started

* Watch Sass file `sass --watch scss/main.scss css/main.css`.
* Go to your local dev env `[DOCROOT]/src`.
