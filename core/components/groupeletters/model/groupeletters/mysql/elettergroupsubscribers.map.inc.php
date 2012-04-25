<?php
$xpdo_meta_map['EletterGroupSubscribers']= array (
  'package' => 'groupeletters',
  'version' => '1.1',
  'table' => 'eletter_group_subscribers',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'group' => NULL,
    'subscriber' => NULL,
    'receive_email' => 'Y',
    'receive_sms' => 'N',
    'date_created' => NULL,
    'date_updated' => NULL,
  ),
  'fieldMeta' => 
  array (
    'group' => 
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
    'receive_email' => 
    array (
      'dbtype' => 'set',
      'precision' => '\'Y\',\'N\'',
      'phptype' => 'string',
      'null' => true,
      'default' => 'Y',
    ),
    'receive_sms' => 
    array (
      'dbtype' => 'set',
      'precision' => '\'Y\',\'N\'',
      'phptype' => 'string',
      'null' => true,
      'default' => 'N',
    ),
    'date_created' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
    'date_updated' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
  ),
  'indexes' => 
  array (
    'group' => 
    array (
      'alias' => 'group',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'group' => 
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
    'Group' => 
    array (
      'class' => 'EletterGroups',
      'local' => 'group',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
