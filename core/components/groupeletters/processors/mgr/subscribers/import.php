<?php
$messages = array();
$importCount = 0;
$newCount = 0;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(is_uploaded_file($_FILES['csv']['tmp_name']) ) {
        if (($handle = fopen($_FILES['csv']['tmp_name'], "r")) !== FALSE) {
            $columns =  fgetcsv($handle, 0, ";");
            if( !is_array($columns) || $columns[0] != 'email' ) {
                $messages[] = $modx->lexicon('groupeletters.subscribers.importcsv.err.firstrow'); //first row must contain column names and start with email
            } else {
                $i = 2;
                while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
                    if( count($data) == count($columns) ) {
                        $new = false;
                        $subscriber = $modx->getObject('EletterSubscribers', array('email' => $data[0]));
                        if(!is_object($subscriber))
                        {
                            $new = true;
                            $subscriber = $modx->newObject('EletterSubscribers');
                            $subscriber->set('code', md5($data[0].time())  );
                            $subscriber->set('active', 1 );
                        }

                        $num = count($columns);
                        for ($c=0; $c < $num; $c++) {
                            if($columns[$c] != 'groups')
                            {
                                $subscriber->set( $columns[$c], trim($data[$c]) );
                            }
                            else
                            {
                                $groups = $data[$c];
                            }
                        }
                        if ($subscriber->save() == false) {
                            $messages[] = $modx->lexicon('groupeletters.subscribers.importcsv.err.cantsaverow', array('rownum' => $i)); //can't save row
                            //$messages[] =  implode(',', $subscriber->get( array('firstname', 'lastname', 'code', 'email', 'active') ) );
                        } else {
                            //remove current groups and add new groups
                            $modx->removeCollection('EletterGroupSubscribers', array('subscriber' => $subscriber->get('id')));
                            $groups = preg_split('/[\s,]+/', $groups);
                            foreach($groups as $group)
                            {
                                if($group) { //prevent 0
                                    $subgroup = $modx->newObject('EletterGroupSubscribers');
                                    $subgroup->set('subscriber', $subscriber->get('id'));
                                    $subgroup->set('group', (int)$group);
                                    $subgroup->save();
                                }
                            }
                            $importCount++;
                            if($new) {
                                $newCount++;
                            }
                        }
                    } else {
                        $messages[] = $modx->lexicon('groupeletters.subscribers.importcsv.err.skippedrow', array('rownum' => $i)); //slipped invalid row
                    }
                    $i++;
                }
                $messages[] = $modx->lexicon('groupeletters.subscribers.importcsv.msg.complete', array('importCount' => $importCount, 'newCount' => $newCount)); //import complete + totals
            }
        } else {
            $messages[] = $modx->lexicon('groupeletters.subscribers.importcsv.err.cantopenfile'); exit; //can't open file
        }
    } else {
        $messages[] = $modx->lexicon('groupeletters.subscribers.importcsv.err.uploadfile'); //please upload file
    }

    $msg = htmlentities( implode('<br>', $messages) );
    return $modx->error->success($msg);
}