#!/usr/bin/php -f
<?php
/**
 * primaERP - Example how to check connection
 *
 * @author     Vítězslav Dvořák <info@vitexsofware.cz>
 * @copyright  (G) 2017 Vitex Software
 */

namespace Example\primaERP;

include_once './config.php';
include_once '../vendor/autoload.php';

$client   = new \primaERP\ApiClient(null, ['section' => 'licenses']);
$licenses = $client->requestData();

if (count($licenses)) {
    $client->addStatusMessage('Connection OK', 'success');
    $client->addStatusMessage('token:'.$client->getTokenString(), 'debug');
    var_dump($licenses);
} else {
    $client->addStatusMessage('Connection failed', 'warning');
}
