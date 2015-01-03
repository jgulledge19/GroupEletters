<?php
/**
 * Get a list of newsletters
 *
 *
 * @package eletters
 * @subpackage processors.newsletters.list
 */


/* setup default properties */
$isLimit    = !empty($_REQUEST['limit']);
$start      = $modx->getOption('start',$_REQUEST,0);
$limit      = $modx->getOption('limit',$_REQUEST,10);
$sort       = $modx->getOption('sort',$_REQUEST,'start_date');
$dir        = $modx->getOption('dir',$_REQUEST,'DESC');

/* query for newsletters */
$c = $modx->newQuery('EletterNewsletters');
$count = $modx->getCount('EletterNewsletters',$c);

$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$newsletters = $modx->getCollection('EletterNewsletters',$c);

/* iterate through newsletters */
$list = array();
foreach ($newsletters as $newsletter) {
    //$total = $modx->getCount('EletterQueue',array('newsletter' => $newsletter->get('id')));
    //$sent = $modx->getCount('EletterQueue',array('newsletter' => $newsletter->get('id'), 'sent' => 1));
    $newsletter = $newsletter->toArray();
    // get stats:
    /**
     * Email Statistics: http://www.idealware.org/articles/email_metrics.php
        - Messages Sent. This is the number of outbound emails sent as part of a particular mailing.
        - Messages Delivered. This is the number of sent emails actually delivered to recipients’ inboxes. 
            If they’re not delivered, that means they’ve “bounced”.
        - Hard and Soft Bounces. A hard bounce is a permanently undeliverable email—for example, one sent to an invalid 
            email address (joesmith@yahoo.con) or to an address that no longer exists. A soft bounce is an email that is 
            only temporarily undeliverable—for example, to a recipient whose mailbox is full. Ideally, you should track both.
        - Unsubscribes. This is the number of individuals who unsubscribe from your list in response to each mailing sent.
        - Messages Opened. This is the number of recipients who open your email to read it. Due to the way open rates are 
            tracked and the rise of image-blocking software, this number will never be accurate, but can still be useful.
        - Click-Throughs. This is the number of times any recipient clicks on any trackable link within the email. 
            Ideally, each link should be counted only once, even if it is clicked on multiple times.

     * 
     */
    //$newsletter['delivered'] = (int)$total;// total in the queue sent
    //$newsletter['sent'] = (int)$sent;// sent_cnt - total that sent with out error
    // delivered
    $openend = $modx->getCount('EletterSubscriberHits',array('newsletter' => $newsletter['id'], 'hit_type' => 'image' ) );
    $newsletter['opened'] = (int)$openend;
    $clicks = $modx->getCount('EletterSubscriberHits',array('newsletter' => $newsletter['id'], 'hit_type' => 'click' ) );
    $newsletter['clicks'] = (int)$clicks;
    
    if ( empty($newsletter['start_date']) ) {
        $newsletter['date'] = ' - ';
    } else {
        $newsletter['date'] = date($modx->getOption('manager_date_format', NULL, 'Y-m-d').' '.$modx->getOption('manager_time_format', NULL, 'g:i a') ,strtotime($newsletter['start_date']));
    }
    // do end date:
    if ( empty($newsletter['finish_date']) ) {
        $newsletter['date'] .= ' - ';
    } else {
        $newsletter['date'] .= ' - '. date($modx->getOption('manager_date_format', NULL, 'Y-m-d').' '.$modx->getOption('manager_time_format', NULL, 'g:i a') ,strtotime($newsletter['finish_date']));
    }
    $list[] = $newsletter;
}
return $this->outputArray($list,$count);