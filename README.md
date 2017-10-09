# primaERP PHP Library

PHP Library for easy interaction with [ABRA](https://www.abra.eu/)'s [primaERP](http://devdoc.primaerp.com/index.html)

[![Source Code](http://img.shields.io/badge/source/VitexSoftware/php-primaERP-blue.svg?style=flat-square)](https://github.com/VitexSoftware/php-primaERP)
[![Latest Version](https://img.shields.io/github/release/VitexSoftware/php-primaERP.svg?style=flat-square)](https://github.com/VitexSoftware/php-primaERP/releases)
[![Software License](https://img.shields.io/badge/license-GNU-brightgreen.svg?style=flat-square)](https://github.com/VitexSoftware/php-primaERP/blob/master/LICENSE)
[![Build Status](https://img.shields.io/travis/VitexSoftware/php-primaERP/master.svg?style=flat-square)](https://travis-ci.org/VitexSoftware/php-primaERP)
[![Code Coverage](https://scrutinizer-ci.com/g/VitexSoftware/php-primaERP/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/VitexSoftware/php-primaERP/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/VitexSoftware/php-primaERP.svg?style=flat-square)](https://packagist.org/packages/VitexSoftware/php-primaERP)
[![Latest stable](https://img.shields.io/packagist/v/VitexSoftware/php-primaERP.svg?style=flat-square)](https://packagist.org/packages/VitexSoftware/php-primaERP)

Installation
------------

    composer require vitexsoftware/primaerp

Configuration
-------------

Please set up following constants:

```php
/*
 * primaERP API user comany/account name
 */
define('PRIMAERP_COMPANY', 'vitexsoftware');

/*
 * URL primaERP API
 */
define('PRIMAERP_URL',
    'https://'.constant('PRIMAERP_COMPANY').'.api.primaerp.com');

/*
 * Login is Email primaERP API user
 */
define('PRIMAERP_LOGIN', 'email@domain.tld');

/*
 * primaERP API user password
 */
define('PRIMAERP_PASSWORD', 'password');

/*
 * primaERP API KEY
 */
define('PRIMAERP_APIKEY', '1af7a44b-81f1-4de1-11e7-1e675acb1221');

```

nebo je možné přihlašovací údaje zadávat při vytváření instance třídy.

```php
$projector = new ApiClient(null, ['section' => 'time','user'=>'email@some.ser','password'=>'XXXX','apikey'=>'1af7a44b-81f1-4de1-11e7-1e675acb1221']);
$projects  = $projector->requestData('projects');
```

Tento způsob nastavení má vyšší prioritu než výše uvedené definovaní konstant.


Debian/Ubuntu
-------------

Pro Linux jsou k dispozici .deb balíčky. Prosím použijte repo:

    wget -O - http://v.s.cz/info@vitexsoftware.cz.gpg.key|sudo apt-key add -
    echo deb http://v.s.cz/ stable main > /etc/apt/sources.list.d/ease.list
    aptitude update
    aptitude install php-primaerp


