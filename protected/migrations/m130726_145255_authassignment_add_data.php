<?php

class m130726_145255_authassignment_add_data extends CDbMigration
{
	public function up()
	{
        $this->insert('authassignment',array('itemname'=>'superadmin','userid'=>2));
        $this->insert('authassignment',array('itemname'=>'superadmin','userid'=>7));
        $this->insert('authassignment',array('itemname'=>'superadmin','userid'=>8));
        $this->insert('authassignment',array('itemname'=>'admin','userid'=>5));
        $this->insert('authassignment',array('itemname'=>'admin','userid'=>6));
        $this->insert('authassignment',array('itemname'=>'admin','userid'=>9));
        $this->insert('authassignment',array('itemname'=>'admin','userid'=>10));
	}

	public function down()
	{
		echo "m130726_145255_authassignment_add_data does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}