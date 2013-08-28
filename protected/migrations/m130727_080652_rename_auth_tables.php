<?php

class m130727_080652_rename_auth_tables extends CDbMigration
{
	public function up()
	{
        $this->renameTable('authitem','auth_item');
        $this->renameTable('authitemchild','auth_item_self_assn');
        $this->renameTable('authassignment','auth_item_user_assn');
	}

	public function down()
	{
		echo "m130727_080652_rename_auth_tables does not support migration down.\n";
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