<?php
/**
 * Hook for FormIt 
 * @return (Boolean)
 *  
 * Does all of the following: http://rtfm.modx.com/display/ADDON/FormIt.Hooks.email
 * And these:
 * 
    emailNewsletterID (Int) use the newsletter ID to identify the newsletter 
    emailResourceID - (Int), Optional instead of using the emailNewsletterID use the standard resource ID to identify the newsletter 
    emailUseChunk - Boolean, default false - on true it will use the standard chunk rather then the newsletter
    emailUploads - Boolean, default true - on true will send uploads via email
    emailFiles - Boolean, default true - on true will send any files attachments that a newsletter may have
    emailLog - Boolean, default true - on true will save output email content to database and allow a you to 
               create a link to View as Webpage.  Will also log any error if email is not delivered. 
 * 
 * 
 * custom snippet hook: 
    $properties = array_merge($this->formit->config,$customProperties);
    $properties['formit'] =& $this->formit;
    $properties['hook'] =& $this;
    $properties['fields'] = $this->fields;
    $properties['errors'] =& $this->errors;
    
    $success = $snippet->process($properties);
 * 
 * 
 */
 
if (!isset($modx->eletters)) {
    $modx->addPackage('eletters', $modx->getOption('core_path').'components/eletters/model/');
    $modx->eletters = $modx->getService('eletters', 'Eletters', $modx->getOption('core_path').'components/eletters/model/eletters/');
}
$eletters =& $modx->eletters;

return $eletters->formItEmail($formit, $hook, $fields);

