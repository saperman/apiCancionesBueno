<?php 

class Model_Songs extends Orm\Model
{
    protected static $_table_name = 'Songs';
    protected static $_primary_key = array('id');
    protected static $_properties = array
    ('id' => array('data_type'=>'int'),
     'title' => array(
           		'data_type' => 'text'   
        	),
     'url' => array(
            	'data_type' => 'text'   
        	)
    );
}