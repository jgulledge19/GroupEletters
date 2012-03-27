<?php
if($doc = $modx->getObject('modResource', $scriptProperties['document'])) {

    $docUrl = preg_replace('/&amp;/', '&', $modx->makeUrl((int)$scriptProperties['document'], '', '&sending=1', 'full') );

    $context = $modx->getObject('modContext', array('key' => $doc->get('context_key')));
    $contextUrl = $context->getOption('site_url', $modx->getOption('site_url'));
    unset($context);
    
    $message = file_get_contents($docUrl);
    $message = str_replace('&#91;&#91;', '[[', $message); //convert entities back to normal placeholders
    $message = str_replace('&#93;&#93;', ']]', $message); //convert entities back to normal placeholders

    //CSS inline
    $modx->getService('emogrifier', 'Emogrifier', $modx->getOption('core_path').'components/ditsnews/model/emogrifier/');
    $cssStyles = '';
    preg_match_all('|<style(.*)>(.*)</style>|isU', $message, $css);
    if( !empty($css[2]) )
    {
        foreach( $css[2] as $cssblock )
        {
            $cssStyles .= $cssblock;
        }
    }
    $modx->emogrifier->setCSS($cssStyles);
    $modx->emogrifier->setHTML($message);
    $message = $modx->emogrifier->emogrify();

    $newsletter = $modx->newObject('dnNewsletter', array(
        'title' => $scriptProperties['title'],
        'date' => time(),
        'document' => (int) $scriptProperties['document'],
        'message' => $message
    ));

    //add groups
    $sendToGroups = array();
    $groups = $modx->getCollection('dnGroup');
    if( is_array($groups) ) {
        foreach($groups as $group) {
            $id = $group->get('id');
            if( $scriptProperties['groups_'.$id] ) {
                $sendToGroups[] = $group->get('id');
            }
        }
    }

    // Return values
    if ($newsletter->save()) {
        if(count($sendToGroups)) {
            $c = $modx->newQuery('dnSubscriber');
            $c->leftJoin('dnGroupSubscribers', 'Groups');
            $c->where('Groups.group IN('.implode($sendToGroups, ',').')');
            $c->andCondition(array('dnSubscriber.active' => 1));
            $subscribers = $modx->getCollection('dnSubscriber' , $c);
            foreach($subscribers as $subscriber) {
                $queueItem = $modx->newObject('dnQueue');
                $queueItem->fromArray(
                    array(
                        'newsletter' => $newsletter->get('id'),
                        'subscriber' => $subscriber->get('id'),
                        'sent' => 0
                    )
                );
                $queueItem->save();
            }
        }
        return $modx->error->success('', $newsletter);
    } else {
        return $modx->error->failure('');
    }

}
else {
    return $modx->error->failure($modx->lexicon('ditsnews.newsletters.err.nf'));
}





