<?php

class m130726_150158_authassignment_consultant extends CDbMigration
{
	public function up()
	{
        $this->insert('authassignment',array('itemname'=>'consultant','userid'=>390));
	}

	public function down()
	{
		echo "m130726_150158_authassignment_consultant does not support migration down.\n";
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