<?php

class m130727_101146_manage_email_sending extends CDbMigration
{
	public function up()
	{

        $this->insert('auth_item',array('name'=>'manage_email_sending','type'=>1,'description'=>'Управление email рассылками'));
	}

	public function down()
	{
		echo "m130727_101146_manage_email_sending does not support migration down.\n";
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