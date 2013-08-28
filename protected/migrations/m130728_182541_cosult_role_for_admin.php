<?php

class m130728_182541_cosult_role_for_admin extends CDbMigration
{
	public function up()
	{
        $this->insert('auth_item_self_assn',array('parent'=>'superadmin','child'=>'consultant'));
	}

	public function down()
	{
		echo "m130728_182541_cosult_role_for_admin does not support migration down.\n";
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