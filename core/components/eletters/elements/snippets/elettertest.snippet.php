<?php

if (!isset($modx->eletters)) {
    $modx->addPackage('eletters', $modx->getOption('core_path').'components/eletters/model/');
    $modx->eletters = $modx->getService('eletters', 'Eletters', $modx->getOption('core_path').'components/eletters/model/eletters/');
}
$eletters =& $modx->eletters;
 
if( !$newsletter = $modx->getObject('EletterNewsletters', array('resource' => 2067 )) ) {
    // create a new newsletter:
    $newsletter = $modx->newObject('EletterNewsletters', array(
        'title' => $scriptProperties['title'],
        'date' => time(),
        'resource' => 2067,
        'message' => $message
    ));
} 

$newsletter->sendTest('gulledj@bethelcollege.edu');
