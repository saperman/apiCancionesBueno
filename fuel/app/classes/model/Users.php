<?php

class Model_Users extends Orm\Model 
{
    protected static $_table_name = 'Usuarios';
    protected static $_primary_key = array('id');
    protected static $_properties = array
    ('id' => array('data_type'=>'int'), // both validation & typing observers will ignore the PK
     'userName' => array(
            'data_type' => 'varchar',
            'validation' => array('required', 'max_length' => array(20))
        ),
     'password' => array(
                'data_type' => 'varchar',
                'validation' => array('required', 'max_length' => array(20))   
            )
    );

}