<?php

class m130727_082128_manage_admin extends CDbMigration
{
	public function up()
	{
        $this->insert('auth_item',array('name'=>'manage_admin','type'=>2,'description'=>'Управление администраторами'));
	}

	public function down()
	{
		echo "m130727_082128_manage_admin does not support migration down.\n";
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