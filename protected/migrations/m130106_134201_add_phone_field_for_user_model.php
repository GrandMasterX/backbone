<?php

class m130106_134201_add_phone_field_for_user_model extends CDbMigration
{
	public function up()
	{
        $this->addColumn('user', 'phone', 'varchar(30)');
	}

	public function down()
	{
		echo "m130106_134201_add_phone_field_for_user_model does not support migration down.\n";
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