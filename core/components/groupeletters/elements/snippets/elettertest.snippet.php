<?php
require_once MODX_CORE_PATH.'/components/ditsnews/model/ditsnews/ditsnews.class.php';
$ditsnews = new Ditsnews($modx);

if( !$newsletter = $modx->getObject('dnNewsletter', array('resource' => 2067 )) ) {
    // create a new newsletter:
    $newsletter = $modx->newObject('dnNewsletter', array(
        'title' => $scriptProperties['title'],
        'date' => time(),
        'resource' => 2067,
        'message' => $message
    ));
} 

$newsletter->sendTest('gulledj@bethelcollege.edu');
