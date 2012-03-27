<?php
$xpdo_meta_map['EletterNewsletters']= array (
  'package' => 'groupeletters',
  'version' => '1.1',
  'table' => 'eletter_newsletters',
  'composites' => 
  array (
    'Groups' => 
    array (
      'class' => 'EletterNewsletterGroups',
      'local' => 'id',
      'foreign' => 'newsletter',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Queue' => 
    array (
      'class' => 'EletterQueue',
      'local' => 'id',
      'foreign' => 'newsletter',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Hits' => 
    array (
      'class' => 'EletterSubscriberHits',
      'local' => 'id',
      'foreign' => 'newsletter',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'fields' => 
  array (
    'resource' => 0,
    'title' => NULL,
    'message' => NULL,
    'subject' => NULL,
    'from' => NULL,
    'from_name' => NULL,
    'reply_to' => NULL,
    'groups' => NULL,
    'status' => 'draft',
    'allow_comments' => 'N',
    'user' => NULL,
    'add_date' => NULL,
    'start_date' => NULL,
    'finish_date' => NULL,
    'sent_cnt' => 0,
    'tot_cnt' => 0,
    'bounce_cnt' => 0,
    'extended' => NULL,
  ),
  'fieldMeta' => 
  array (
    'resource' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
      'index' => 'index',
    ),
    'title' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => true,
    ),
    'message' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'subject' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => true,
    ),
    'from' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => true,
    ),
    'from_name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => true,
    ),
    'reply_to' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => true,
    ),
    'groups' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
    ),
    'status' => 
    array (
      'dbtype' => 'set',
      'precision' => '\'draft\',\'submitted\',\'approved\',\'complete\',\'sending\',\'void\'',
      'phptype' => 'string',
      'null' => true,
      'default' => 'draft',
    ),
    'allow_comments' => 
    array (
      'dbtype' => 'set',
      'precision' => '\'Y\',\'N\'',
      'phptype' => 'string',
      'null' => true,
      'default' => 'N',
    ),
    'user' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
    ),
    'add_date' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
    'start_date' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
    'finish_date' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
    'sent_cnt' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
    'tot_cnt' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
    'bounce_cnt' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
    'extended' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
  ),
  'indexes' => 
  array (
    'resource' => 
    array (
      'alias' => 'resource',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'resource' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
      ),
    ),
  ),
);
