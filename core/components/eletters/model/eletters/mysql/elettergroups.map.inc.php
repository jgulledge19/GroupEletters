<?php
$xpdo_meta_map['EletterGroups']= array (
  'package' => 'eletters',
  'version' => '1.1',
  'table' => 'eletter_groups',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'name' => NULL,
    'parent' => 0,
    'group_type' => 'Campaign',
    'member_group_id' => NULL,
    'description' => NULL,
    'department' => NULL,
    'allow_signup' => 'N',
    'date_created' => NULL,
    'active' => 'Y',
    'date_inactive' => NULL,
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => true,
    ),
    'parent' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
    'group_type' => 
    array (
      'dbtype' => 'set',
      'precision' => '\'Campaign\',\'MODX\',\'Dynamic\'',
      'phptype' => 'string',
      'null' => true,
      'default' => 'Campaign',
    ),
    'member_group_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'department' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '64',
      'phptype' => 'string',
      'null' => true,
    ),
    'allow_signup' => 
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
    'active' => 
    array (
      'dbtype' => 'set',
      'precision' => '\'Y\',\'N\'',
      'phptype' => 'string',
      'null' => true,
      'default' => 'Y',
    ),
    'date_inactive' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
  ),
  'composites' => 
  array (
    'Subscribers' => 
    array (
      'class' => 'EletterGroupSubscribers',
      'local' => 'id',
      'foreign' => 'group',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Newsletters' => 
    array (
      'class' => 'EletterNewsletterGroups',
      'local' => 'id',
      'foreign' => 'group',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'validation' => 
  array (
    'rules' => 
    array (
      'name' => 
      array (
        'preventBlank' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'xPDOMinLengthValidationRule',
          'value' => '1',
          'message' => 'Name is required.',
        ),
      ),
    ),
  ),
);
