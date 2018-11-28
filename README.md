# world-wide-importers

Schoolproject 'world wide importers'.

## Requirements

* [NodeJS](https://nodejs.org/en/)
* [SASS](https://sass-lang.com/)
* Local development environment (eg. [XAMMP](https://www.apachefriends.org/index.html) for Windows user and [MAMP](https://www.mamp.info/en/) for Mac users);
* [Composer](https://getcomposer.org/)

## Installation

Installation requires PHP 7.1+ (included with [XAMMP](https://www.apachefriends.org/index.html) or [MAMP](https://www.mamp.info/en/))

You need to install the following (if not installed):

* [NodeJS](https://nodejs.org/en/) (global)
* [Composer](https://getcomposer.org/download/) (global).

  * **Windows**
  
    1. Download the installer [here](https://getcomposer.org/Composer-Setup.exe).
    2. Execute the installer from the download directory as administrator.
    3. Follow the steps and install Composer.
    4. Congratulations, composer is installed on your machine!

  * **Mac**:

    1. Make sure you have PHP installed global.
    2. Run the following code inside your terminal:  
      `php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
      php -r "if (hash_file('sha384', 'composer-setup.php') === '93b54496392c062774670ac18b134c3b3a95e5a5e5c8f1a9f115f203b75bf9a129d5daa8ba6a13e2cc8a1da0806388a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
      php composer-setup.php
      php -r "unlink('composer-setup.php');"`
    3. Congratulations, composer is installed on your machine!

## Getting started

First install required Node packages for development with:

* `$ npm install -g sass`
* `$ npm install -g localtunnel`
  
Install the by Composer required packages in `$ ~/world-wide-importers/src`:

* `$ composer install`

### Development

Be sure to be in the `$ ~/world-wide-importers/src` folder when executing the following commands in your terminal.

* Watch Sass file `sass --watch scss/main.scss css/main.css`.
* Run webserver `lt --port [local webserverport]`
  * Go to the URI provided by the command above. It should look like `something.localtunnel.me`
* Add your password from a gmail to `/inc/password.php` to enable mailing.
