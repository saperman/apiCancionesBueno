<?php
namespace Fuel\Migrations;

class Songs
{
		
    function up()
    {	
    	\DBUtil::create_table('Canciones',
	    	array(
	    		'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
	    		'title' => array('type' => 'text'),
	    		'url' => array('type' => 'text'),
	    	),
	    	array('id'), false, 'InnoDB', 'utf8_general_ci'
		);
    }

    function down()
    {
       \DBUtil::drop_table('Canciones');
    }

}