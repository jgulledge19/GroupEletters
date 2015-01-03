<?php
/**
 * Hook for FormIt - send auto responder/reply
 * @return (Boolean)
 *  
 * Does all of the following: http://rtfm.modx.com/display/ADDON/FormIt.Hooks.FormItAutoResponder
 * and http://rtfm.modx.com/display/ADDON/FormIt.Hooks.email but with the fiar prefix instead of email
 * And these:
 * 
    fiarNewsletterID (Int) use the newsletter ID to identify the newsletter 
    fiarResourceID - (Int), Optional instead of using the NewsletterID use the standard resource ID to identify the newsletter 
    eamilUseChunk - Boolean, default false - on true it will use the standard chunk rather then the newsletter
    fiarUploads - Boolean, default true - on true will send uploads via email
    fiarFiles - Boolean, default true - on true will send any files attachments that a newsletter may have
    fiarLog - Boolean, default true - on true will save output email to database
jgulledge * 
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

return $eletters->formItAutoReply($formit, $hook, $fields);


