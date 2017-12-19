<?php 

class Model_Lists extends Orm\Model
{
    protected static $_table_name = 'lists';
    protected static $_primary_key = array('id');
    protected static $_properties = array
    ('id' => array('data_type'=>'int'),
     'title' => array(
            'data_type' => 'text'   
        ),
     'id_user' => array(
            'data_type' => 'int'   
        )
    );
    protected static $_belongs_to = array(
	    'user' => array(
	        'key_from' => 'id_user',
	        'model_to' => 'Model_Users',
	        'key_to' => 'id',
	        'cascade_save' => true,
	        'cascade_delete' => false,
	    )
	);
}