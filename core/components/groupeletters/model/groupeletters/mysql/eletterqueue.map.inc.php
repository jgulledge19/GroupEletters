<?php
$xpdo_meta_map['EletterQueue']= array (
  'package' => 'groupeletters',
  'version' => '1.1',
  'table' => 'eletter_queue',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'newsletter' => 0,
    'subscriber' => 0,
    'sent' => 0,
  ),
  'fieldMeta' => 
  array (
    'newsletter' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
    'subscriber' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
    'sent' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
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
          'null' => false,
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
          'null' => false,
        ),
      ),
    ),
  ),
  'aggregates' => 
  array (
    'Newsletter' => 
    array (
      'class' => 'EletterNewsletters',
      'local' => 'newsletter',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Subscriber' => 
    array (
      'class' => 'EletterSubscribers',
      'local' => 'subscriber',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
