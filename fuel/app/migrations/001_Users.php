<?php

namespace Fuel\Migrations;


class Users
{

    function up()
    {
        \DBUtil::create_table('Usuarios', 
            array(
                'id' => array('type' => 'int', 'constraint' => 11,'auto_increment' => true),
                'userName' => array('type' => 'varchar', 'constraint' => 100),
                'password' => array('type'=> 'varchar', 'constraint' => 20)
                // 'password' => array('type'=> 'varchar', 'constraint' => 100),
        ), array('id'));    
    }

    function down()
    {
       \DBUtil::drop_table('Usuarios');
    }
}