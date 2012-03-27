<?php
header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=subscribers.csv");

echo 'email;firstname;lastname;company;active;groups'.PHP_EOL;

$subscribers = $modx->getCollection('dnSubscriber');
foreach($subscribers as $subscriber)
{
    echo $subscriber->get('email').';';
    echo $subscriber->get('firstname').';';
    echo $subscriber->get('lastname').';';
    echo $subscriber->get('company').';';
    echo $subscriber->get('active').';';

    $groups = $subscriber->getMany('Groups');
    $i = 0;
    foreach($groups as $group)
    {
        if($i > 0)
            echo ',';
        echo $group->get('group');
        $i++;
    }
    echo PHP_EOL;
}

exit;