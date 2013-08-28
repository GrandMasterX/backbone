<?php

class m130728_184400_assign_role_for_user_255 extends CDbMigration
{
	public function up()
	{
        $this->insert('auth_item_user_assn',array('itemname'=>'superadmin','userid'=>255));
	}

	public function down()
	{
		echo "m130728_184400_assign_role_for_user_255 does not support migration down.\n";
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