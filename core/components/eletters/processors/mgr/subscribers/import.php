<?php
/**
 * Import the CSV:
 */

$newData = array();
$total = $imported = $exists = $invalid = 0;

// get possible group ids:
$my_groups = array();
foreach ( $scriptProperties as $property=>$value ) {
    if ( !is_string($property) ) {
        continue;
    }
    // $modx->log(modX::LOG_LEVEL_ERROR,'[Group ELetters/Process/Import()] Property: ('.$property .')');
    if ( strpos($property,'groups_') === 0 ) {
        // $modx->log(modX::LOG_LEVEL_ERROR,'[Group ELetters/Process/Import()] Add to Group: ('.$property .')');
        $my_groups[] = str_replace('groups_', '', $property);
    }
}

// $modx->log(modX::LOG_LEVEL_ERROR,'[Group ELetters/Process/Import()] Individual: start!');
$groups = $modx->getCollection('EletterGroups', array('id:IN'=>$my_groups));

$error_message = '';
$row_invalid_email = array();
$row_already_exists = array();

if (!empty($_FILES['csv']['name']) && !empty($_FILES['csv']['tmp_name'])) {
    require_once MODX_CORE_PATH.'components/eletters/model/eletters/csv.class.php';
    $csv = new CSV();
    // returns array( name=>value)
    
    $csv->autoDetect(TRUE);// this just sets ini_set('auto_detect_line_endings', VALUE);
    
    $data = $csv->import($_FILES['csv']['tmp_name']);// return the data without the header column but in name(column)=>value pairs
    if ( $data === FALSE ) {
        return $modx->error->failure($modx->lexicon('eletters.subscribers.importcsv.err.cantopenfile') );
    } else {
        $total = count($data);
        $row_number = 1;
        foreach ( $data as $individual ) {
            // $modx->log(modX::LOG_LEVEL_ERROR,'[ELetters/Process/Import()] Individual: ('.print_r($individual,TRUE) .')');
            $row_number++;
            if (!isset($individual['email']) || empty($individual['email'])) {
                // if there is no email do not import
                $row_invalid_email[] = $row_number;
                $invalid++;
                continue;
            }
            $subscriber = $modx->getObject('EletterSubscribers', array('email'=>$individual['email']));
            if ( is_object($subscriber) ) {
                // they already exist!
                $row_already_exists[] = $row_number;
                $exists++;
                continue;
            }
            
            $subscriber = $modx->newObject('EletterSubscribers');
            $subscriber->fromArray($individual);
            
            $subscriber->set('code', md5( time().$individual['email'] ));
            //$subscriber->set('active', 0);
            $subscriber->set('date_created', date('Y-m-d H:i:s'));
            $subscriber->set('active', $scriptProperties['active']);
            
            if ($subscriber->save()) {
                
                //add new groups
                foreach($groups as $group) {
                    $id = $group->get('id');
                    // $myGroup = $subscriber->getOne('Groups', array('group' => $id) );
                    $myGroup = $modx->getObject('EletterGroupSubscribers', array('group'=>$id,'subscriber'=>$subscriber->get('id')));
                            // add subsciber to group
                    // $modx->log(modX::LOG_LEVEL_ERROR,'[ELetters/Process/Import()] add Subscriber for group ('.$subscriber->get('id') .') to GroupID: '.$id);
                    $GroupSubscribers = $modx->newObject('EletterGroupSubscribers');
                    $GroupSubscribers->set('group', $id);
                    $GroupSubscribers->set('subscriber', $subscriber->get('id'));
                    $GroupSubscribers->set('date_created', date('Y-m-d h:i:s'));
                    $GroupSubscribers->save();
                    unset($myGroup);
                    // $this->modx->log(modX::LOG_LEVEL_ERROR,'[ELetters->signup()] GroupID: '.$groupID);
                }
                $imported++;
            } else {
                // there was an error!
                $validator = $subscriber->getValidator();
                $error = '';
                if ($validator->hasMessages()) {
                    foreach ($validator->getMessages() as $message) {
                        $this->addFieldError($message['field'],$this->modx->lexicon($message['message']));
                        if (!empty($error)) {
                            $error .= PHP_EOL.str_pad(' ', 20);
                        }
                        $error .= 'Row: '.$row_number.' Field ('.$message['field'].') Message ('.$message['message'].')';
                    }
                }
                $modx->log(modX::LOG_LEVEL_ERROR,'[ELetters/Process/Import()] Error saving subscriber: '.$error);
                $error_message .= nl2br($error);
            }
        }
        $status = 'success';
        $message = 'Data was imported';
    }
} else {
    $status = 'failed';
    $message = 'File did not upload';
    $newData[] = array();
    
    return $modx->error->failure($modx->lexicon('eletters.subscribers.importcsv.err.uploadfile') );
}

//$modx->log(modX::LOG_LEVEL_ERROR,'[ELetters/Process/Import()] Imported: '.$total.' imported, '.$invalid.' were invalid and '.$exists.' already existed');

$message = $modx->lexicon(
    'eletters.subscribers.importcsv.msg.complete',
    array(
        'newCount' => $imported,
        'existCount' => $exists,
        'invalidCount' => $invalid,
        'csvCount' => $total
    )
);
// Add in any issues with import data for rows
if ( count($row_already_exists) > 0 || count($row_invalid_email) > 0 || !empty($error_message) ) {
    $message .= '<br> ---------: ----- <br>'.$error_message;
    if (count($row_already_exists) > 0) {
        $message .= '<br>Rows have emails that already exist: '.implode(',', $row_already_exists);
    }
    if (count($row_invalid_email) > 0) {
        $message .= '<br>Rows have invalid/missing email: '.implode(',', $row_invalid_email);
    }
}

return $modx->error->success($message);