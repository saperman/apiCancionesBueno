<?php
namespace Fuel\Migrations;

class Lists
{
		
    function up()
    {	
	    \DBUtil::create_table('Listas',
			array(
    		    'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
	   		    'title' => array('type' => 'text'),
	   		    'id_user' => array('constraint' => 11, 'type' => 'int'),
	    		),
	   		array('id'), false, 'InnoDB', 'utf8_general_ci',
            array(
                array(
                    'constraint' => 'FKListToUsers',
       	            'key' => 'id_user',
   	                'reference' => array(
                	    'table' => 'Usuarios',
                    	'column' => 'id',
            	    ),
                    'on_update' => 'CASCADE',
                    'on_delete' => 'RESTRICT'
                ),
            )
		);
    }

    function down()
    {
       \DBUtil::drop_table('Listas');
    }

}