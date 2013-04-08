# README

## About Snipeg

### Version

* 0.1 alpha

### Website

* http://ghislainphu.github.io/Snipeg

### Wiki and Source code are available on us GitHub repository

* https://github.com/GhislainPhu/Snipeg

## About Licence

This software is provided under the MIT license.
Lets see `COPYING` file provided with this software to learn more.

## About Authors

This software was made by :

	Ghislain Phu
	Révillon Loïk

Lets see `AUTHORS` file provided with this software to learn more.

## About Install

This software is a web application. That mean it require few software in order to work.

* PHP version 5 (5.3 or greater recommended)

* SQLite support http://www.php.net/manual/en/sqlite.setup.php

* JSON support http://www.php.net/manual/en/json.setup.php

* GD extension http://www.php.net/manual/en/image.setup.php

* PDO entension with SQLite driver http://www.php.net/manual/en/pdo.setup.php

## About Security

**WE ADVISE YOU TO USE APACHE AS WEB SERVER IN ORDER TO GET SECURE INSTALL**

In fact, SQLite use files (`*.sqlite`) in your server to store databases.
To deny access to those files, we provide an `.htaccess` which do it.
An other way, whether you won't use apache, could be to configure your server/proxy to deny access to `.sqlite` files.

See "About Security" Wiki for details

* https://github.com/GhislainPhu/Snipeg/wiki/About-Security

## Setup

Getting started :

* Extract archive on your server.

* Run install.php

* Complete form

* **Remove install.php**

You may have to set file permissions on Unix-derived operating systems to :

* 0755 or 0777 on /installdir/snipeg.sqlite
* 0755 or 0777 on /installdir/avatars/ in recursive mode

We hope that Snipeg will be usefull, without give any waranties.
