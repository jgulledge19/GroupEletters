<?php
$settingsArray = (array) json_decode($_REQUEST['formData']);

$settings = $modx->getObject('dnSettings', 1);
if($settings == null){
    $settings = $modx->newObject('dnSettings');
}

$settings->fromArray(array(
    'id' => 1,
    'name' => $settingsArray['name'],
    'email' => $settingsArray['email'],    
    'bounceemail' => $settingsArray['bounceemail']
));

// Return values
if ($settings->save()) {
	return $modx->error->success('', $settings);
} else {
	return $modx->error->failure('');
}