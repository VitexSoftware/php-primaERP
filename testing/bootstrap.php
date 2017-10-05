<?php
/**
 * php-primaERP - testing setup.
 *
 * @author     Vítězslav Dvořák <vitex@arachne.cz>
 * @copyright  2017 Vitex Software
 */
if (file_exists('../vendor/autoload.php')) {
    include_once '../vendor/autoload.php';
} else {
    if (file_exists('vendor/autoload.php')) { //For Test Generator
        include_once 'vendor/autoload.php';
    }
}
/**
 * Write logs as:
 */
define('EASE_APPNAME', 'primaERP_Test');
if (!defined('EASE_LOGGER')) {
    define('EASE_LOGGER', 'syslog');
}

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
define('PRIMAERP_LOGIN', 'info@vitexsoftware.cz');

/*
 * primaERP API user password
 */
define('PRIMAERP_PASSWORD', 'erpjeprima');

/*
 * primaERP API KEY
 */
define('PRIMAERP_APIKEY', '11de0e02-0338-4fda-8d0d-edaa7f170793');
