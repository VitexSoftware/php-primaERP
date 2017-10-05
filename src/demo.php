<?php

namespace primaERP;

require_once '../testing/bootstrap.php';

$oPage     = new \Ease\TWB\WebPage('primaERP Demo');
$container = $oPage->addItem(new \Ease\TWB\Container(new \Ease\Html\H1Tag(_('primaERP Connection Test'))));

$projector = new ApiClient(null, ['section' => 'time']);
$projects  = $projector->requestData('projects');

$container->addItem(new \Ease\Html\PreTag(print_r($projects, true)));

$oPage->addItem($oPage->getStatusMessagesAsHtml());

$oPage->draw();
