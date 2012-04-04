<?php

if (!isset($modx->groupEletters)) {
    $modx->addPackage('groupeletters', $modx->getOption('core_path').'components/groupeletters/model/');
    $modx->groupEletters = $modx->getService('groupeletters', 'GroupEletters', $modx->getOption('core_path').'components/groupeletters/model/groupeletters/');
}
$groupEletters =& $modx->groupEletters;
 
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
