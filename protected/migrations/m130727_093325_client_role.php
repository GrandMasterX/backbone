<?php

class m130727_093325_client_role extends CDbMigration
{
	public function up()
	{
        $this->insert('auth_item',array('name'=>'client','type'=>1,'description'=>'Клиент'));
	}

	public function down()
	{
		echo "m130727_093325_client_role does not support migration down.\n";
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