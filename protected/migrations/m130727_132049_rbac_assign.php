<?php

class m130727_132049_rbac_assign extends CDbMigration
{
	public function up()
	{
        $this->insert('auth_item_self_assn',array('parent'=>'superadmin','child'=>'manage_admin'));
        $this->insert('auth_item_self_assn',array('parent'=>'superadmin','child'=>'manage_email_sending'));
	}

	public function down()
	{
		echo "m130727_132049_rbac_assign does not support migration down.\n";
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