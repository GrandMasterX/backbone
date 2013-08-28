<?php

class m130726_202630_authassignment_update extends CDbMigration
{
	public function up()
	{
        $this->update('authassignment',array('itemname'=>'superadmin','userid'=>1),'userid=:id',array(':id'=>8));
	}

	public function down()
	{
		echo "m130726_202630_authassignment_update does not support migration down.\n";
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