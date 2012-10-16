<?php
$xpdo_meta_map['EletterSubscriberHits']= array (
  'package' => 'groupeletters',
  'version' => '1.1',
  'table' => 'eletter_subscriber_hits',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'newsletter' => NULL,
    'subscriber' => NULL,
    'link' => NULL,
    'hit_type' => NULL,
    'hit_date' => NULL,
    'view_total' => NULL,
  ),
  'fieldMeta' => 
  array (
    'newsletter' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
      'index' => 'index',
    ),
    'subscriber' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
      'index' => 'index',
    ),
    'link' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'string',
      'null' => true,
    ),
    'hit_type' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '16',
      'phptype' => 'string',
      'null' => true,
    ),
    'hit_date' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
    'view_total' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
    ),
  ),
  'indexes' => 
  array (
    'newsletter' => 
    array (
      'alias' => 'newsletter',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'newsletter' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
      ),
    ),
    'subscriber' => 
    array (
      'alias' => 'subscriber',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'subscriber' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
      ),
    ),
  ),
  'aggregates' => 
  array (
    'Subscriber' => 
    array (
      'class' => 'EletterSubscribers',
      'local' => 'subscriber',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Newsletter' => 
    array (
      'class' => 'EletterNewsletters',
      'local' => 'newsletter',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Link' => 
    array (
      'class' => 'EletterLinks',
      'local' => 'link',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
