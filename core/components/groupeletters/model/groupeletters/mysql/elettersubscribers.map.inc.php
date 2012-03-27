<?php
$xpdo_meta_map['EletterSubscribers']= array (
  'package' => 'groupeletters',
  'version' => '1.1',
  'table' => 'eletter_subscribers',
  'composites' => 
  array (
    'Groups' => 
    array (
      'class' => 'EletterGroupSubscribers',
      'local' => 'id',
      'foreign' => 'subscriber',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Queue' => 
    array (
      'class' => 'EletterQueue',
      'local' => 'id',
      'foreign' => 'subscriber',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Hits' => 
    array (
      'class' => 'EletterSubscriberHits',
      'local' => 'id',
      'foreign' => 'subscriber',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'fields' => 
  array (
    'crm_id' => 0,
    'first_name' => NULL,
    'm_name' => NULL,
    'last_name' => NULL,
    'address' => NULL,
    'state' => NULL,
    'zip' => NULL,
    'country' => NULL,
    'email' => NULL,
    'phone' => NULL,
    'cell' => NULL,
    'date_created' => NULL,
    'active' => 0,
  ),
  'fieldMeta' => 
  array (
    'crm_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
    'first_name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '32',
      'phptype' => 'string',
      'null' => true,
    ),
    'm_name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '32',
      'phptype' => 'string',
      'null' => true,
    ),
    'last_name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '32',
      'phptype' => 'string',
      'null' => true,
    ),
    'address' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => true,
    ),
    'state' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '64',
      'phptype' => 'string',
      'null' => true,
    ),
    'zip' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '16',
      'phptype' => 'string',
      'null' => true,
    ),
    'country' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '64',
      'phptype' => 'string',
      'null' => true,
    ),
    'email' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => true,
    ),
    'phone' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '16',
      'phptype' => 'string',
      'null' => true,
    ),
    'cell' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '16',
      'phptype' => 'string',
      'null' => true,
    ),
    'date_created' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
    'active' => 
    array (
      'dbtype' => 'int',
      'precision' => '1',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
  ),
  'validation' => 
  array (
    'rules' => 
    array (
      'email' => 
      array (
        'validEmail' => 
        array (
          'type' => 'preg_match',
          'rule' => '/^[_a-zA-Z0-9-]+(\\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\\.[a-zA-Z0-9-]+)+$/i',
          'message' => 'Email address invalid',
        ),
      ),
    ),
  ),
);
