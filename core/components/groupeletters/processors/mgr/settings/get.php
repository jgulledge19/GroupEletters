<?php
$settings = $modx->getObject('dnSettings', 1);

if($settings == null){
    $settings = $modx->newObject('dnSettings');
    $settings->set('name', 'Your name');
    $settings->set('email', 'your@email.tld');
    $settings->set('bounceemail', 'your@email.tld');
    $settings->save();
}

$settingsArray = $settings->toArray();

return $modx->error->success('', $settingsArray);