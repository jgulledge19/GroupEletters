<?php
$xpdo_meta_map['EletterLog']= array (
  'package' => 'eletters',
  'version' => '1.1',
  'table' => 'eletter_log',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'newsletter' => NULL,
    'user_id' => NULL,
    'crm_id' => NULL,
    'verified' => 'N',
    'ecode' => NULL,
    'from_address' => NULL,
    'from_name' => NULL,
    'ishtml' => 'N',
    'to_address' => NULL,
    'to_name' => NULL,
    'cc_address' => NULL,
    'cc_name' => NULL,
    'bcc_address' => NULL,
    'bcc_name' => NULL,
    'reply_to_address' => NULL,
    'reply_to_name' => NULL,
    'subject' => NULL,
    'message' => NULL,
    'text_message' => NULL,
    'status' => 'Sending',
    'spam' => 'N',
    'create_date' => NULL,
    'resend_count' => 0,
    'resend_info' => NULL,
    'resend_date' => NULL,
    'sender_ip' => NULL,
    'sender_pc_name' => NULL,
    'category' => NULL,
    'form_url' => NULL,
    'referal_url' => NULL,
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
    'user_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
      'index' => 'index',
    ),
    'crm_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
      'index' => 'index',
    ),
    'verified' => 
    array (
      'dbtype' => 'set',
      'precision' => '\'Y\',\'N\'',
      'phptype' => 'string',
      'null' => true,
      'default' => 'N',
    ),
    'ecode' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '32',
      'phptype' => 'string',
      'null' => true,
      'index' => 'index',
    ),
    'from_address' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
      'index' => 'index',
    ),
    'from_name' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'ishtml' => 
    array (
      'dbtype' => 'set',
      'precision' => '\'Y\',\'N\'',
      'phptype' => 'string',
      'null' => true,
      'default' => 'N',
    ),
    'to_address' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'to_name' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'cc_address' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'cc_name' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'bcc_address' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'bcc_name' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'reply_to_address' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'reply_to_name' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'subject' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
      'index' => 'index',
    ),
    'message' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'text_message' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'status' => 
    array (
      'dbtype' => 'set',
      'precision' => '\'Sending\',\'Delivered\',\'Resent\',\'Failed\'',
      'phptype' => 'string',
      'null' => true,
      'default' => 'Sending',
    ),
    'spam' => 
    array (
      'dbtype' => 'set',
      'precision' => '\'Y\',\'N\'',
      'phptype' => 'string',
      'null' => true,
      'default' => 'N',
    ),
    'create_date' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
    'resend_count' => 
    array (
      'dbtype' => 'int',
      'precision' => '5',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
    'resend_info' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'resend_date' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
    'sender_ip' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '60',
      'phptype' => 'string',
      'null' => true,
    ),
    'sender_pc_name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
    ),
    'category' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '60',
      'phptype' => 'string',
      'null' => true,
    ),
    'form_url' => 
    array (
        'dbtype' => 'text',
        'phptype' => 'string',
        'null' => true,
    ),
    'referal_url' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
  ),
  'indexes' => 
  array (
    'Ecode' => 
    array (
      'alias' => 'Ecode',
      'primary' => false,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
        'ecode' => 
        array (
          'length' => '12',
          'collation' => 'A',
          'null' => true,
        ),
      ),
    ),
    'MODX' => 
    array (
      'alias' => 'MODX',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'user_id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
        'verified' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
      ),
    ),
    'CRM' => 
    array (
      'alias' => 'CRM',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'crm_id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
        'verified' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
      ),
    ),
    'From' => 
    array (
      'alias' => 'From',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'from_address' => 
        array (
          'length' => '15',
          'collation' => 'A',
          'null' => true,
        ),
        'from_name' => 
        array (
          'length' => '10',
          'collation' => 'A',
          'null' => true,
        ),
      ),
    ),
    'Status' => 
    array (
      'alias' => 'Status',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'subject' => 
        array (
          'length' => '25',
          'collation' => 'A',
          'null' => true,
        ),
        'status' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
        'resend_count' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
      ),
    ),
      'Newsletter' =>
          array (
              'alias' => 'Newsletter',
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
                          )
                  ),
          ),
  ),
);
